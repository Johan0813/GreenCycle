<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Trees;
use App\Models\Item;
use App\Models\SeedType;

use Tests\TestCase;

class TreeCareTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (config('database.default') !== 'sqlite' ||
            config('database.connections.sqlite.database') !== ':memory:') {
            throw new \RuntimeException(
                'Las pruebas solo pueden ejecutarse con SQLite en memoria.'
            );
        }
    }

    
    public function test_tree_not_found(): void {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/trees/999999/care');

        $response->assertStatus(404);
    }

        





    public function test_dead_tree(): void {

        $user = User::factory()->create();


        $item = Item::create([
            'name' => 'Dead tree seed',
            'price' => 100,
            'item_type' => 'SEED',
        ]);


        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Dead tree',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);


        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'status' => 'DEAD',
            'health' => 0,
        ]);


        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(409)
            ->assertJsonPath('status', 'DEAD');


        $tree->refresh();


        $this->assertEquals(0, $tree->health);
        $this->assertEquals(0, $tree->progress);
    }







    
    public function test_successful_care(): void{
        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Semilla de prueba',
            'price' => 100,'item_type' => 'SEED',
            ]);
            

            $seedType = SeedType::create([
                'id_item' => $item->id_item,
                'name' => 'Árbol básico',
                'cares_per_level' => 5,
                'harvest_reward' => 50,
                ]);
                

            $tree = Trees::create([
                'id_user' => $user->id_user,
                'id_seed_type' => $seedType->id_seed_type,
                    ]);
                   
                    
            $response = $this->actingAs($user)
                ->postJson("/api/trees/{$tree->id_tree}/care");
                
                
            $response->assertStatus(200)
                ->assertJsonPath('tree.id', $tree->id_tree)
                ->assertJsonPath('tree.level', 0)
                ->assertJsonPath('tree.progress', 1)
                ->assertJsonPath('tree.health', 100)
                ->assertJsonPath('tree.status', 'ACTIVE')
                ->assertJsonStructure([
                    'message','tree' => [
                        'id', 
                        'level', 
                        'health', 
                        'progress', 
                        'status', 
                        'next_care_at'
                        ],

                    ]);
                    

            $tree->refresh();$this->assertNotNull($tree->next_care_at);
            
    }
            



     
            
    public function test_cooldown(): void{

        $user = User::factory()->create();


        $item = Item::create([
            'name' => 'Semilla de prueba cooldown',
            'price' => 100,
            'item_type' => 'SEED',
        ]);


        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Árbol de prueba',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);


        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
        ]);


        $this->actingAs($user);


        $this->postJson("/api/trees/{$tree->id_tree}/care")
        ->assertStatus(200);


        $response = $this->postJson("/api/trees/{$tree->id_tree}/care");


        $response->assertStatus(409)
        ->assertJsonStructure(['message', 'next_care_at']);


        $tree->refresh();


        $this->assertEquals(1, $tree->progress);
    }

    





    public function test_level_up(): void {

        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Semilla para niveles',
            'price' => 100,
            'item_type' => 'SEED',
        ]);


        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Árbol básico',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);


        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
        ]);


        $this->actingAs($user);


        for ($i = 0; $i < 5; $i++) {
            $this->postJson("/api/trees/{$tree->id_tree}/care")
                ->assertStatus(200);

        $tree->refresh();

        if ($i < 4) {  
            $this->travelTo($tree->next_care_at->copy()->addSecond());
            
            }
        }


        $tree->refresh();


        $this->assertEquals(1, $tree->level);
        $this->assertEquals(0, $tree->progress);


        $this->travelBack();

    }






    
    public function test_maturity(): void {

        $user = User::factory()->create();


        $item = Item::create([
            'name' => 'Semilla de madurez',
            'price' => 100,
            'item_type' => 'SEED',
        ]);


        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Arbol de madurez',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);


        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'level' => 9,
            'progress' => 4,
            'status' => 'ACTIVE',
        ]);


        $response = $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care");


        $response->assertStatus(200)
            ->assertJsonPath('tree.level', 10)
            ->assertJsonPath('tree.progress', 0)
            ->assertJsonPath('tree.status', 'MATURE');


        $tree->refresh();


        $this->assertEquals(10, $tree->level);
        $this->assertEquals(0, $tree->progress);
        $this->assertEquals('MATURE', $tree->status);

    }



    

    
    public function test_mature_tree(): void {
        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Mature tree seed',
            'price' => 100,
            'item_type' => 'SEED',
        ]);

        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Mature tree',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);

        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'level' => 10,
            'progress' => 0,
            'status' => 'MATURE',
        ]);

        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(409)
            ->assertJsonPath('status', 'MATURE');

        $tree->refresh();

        $this->assertEquals(10, $tree->level);
        $this->assertEquals(0, $tree->progress);
    }






    public function test_authorization(): void {

        $dueno = User::factory()->create();

        $otroUsuario = User::factory()->create();


        $item = Item::create([
            'name' => 'Semilla para autorización',
            'price' => 100,
            'item_type' => 'SEED',
        ]);


        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Árbol protegido',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);


        $tree = Trees::create([
            'id_user' => $dueno->id_user,
            'id_seed_type' => $seedType->id_seed_type,
        ]);


        $response = $this->actingAs($otroUsuario)
            ->postJson("/api/trees/{$tree->id_tree}/care");


        $response->assertStatus(403);


        $tree->refresh();


        $this->assertEquals(0, $tree->progress);
        $this->assertNull($tree->last_cared_at);

    }









    
    public function test_harvested_tree(): void {

        $user = User::factory()->create();


        $item = Item::create([
            'name' => 'Harvested tree seed',
            'price' => 100,
            'item_type' => 'SEED',
        ]);



        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Harvested tree',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);



        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'level' => 10,
            'status' => 'HARVESTED',
        ]);



        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(409)
            ->assertJsonPath('status', 'HARVESTED');



        $tree->refresh();



        $this->assertEquals(10, $tree->level);
        $this->assertEquals(0, $tree->progress);
        $this->assertEquals('HARVESTED', $tree->status);
}
public function test_care_restores_twenty_health_points(): void
    {
        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Semilla para recuperar salud',
            'price' => 100,
            'item_type' => 'SEED',
        ]);

        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Arbol de recuperacion',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);

        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'health' => 50,
            'status' => 'ACTIVE',
        ]);

        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(200)
            ->assertJsonPath('tree.health', 70);

        $tree->refresh();

        $this->assertEquals(70, $tree->health);
        $this->assertEquals(1, $tree->progress);
    }


    // PRUEBA 11: La salud nunca debe superar 100
    public function test_care_does_not_exceed_maximum_health(): void
    {
        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Semilla para limite de salud',
            'price' => 100,
            'item_type' => 'SEED',
        ]);

        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Arbol de salud maxima',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);

        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'health' => 95,
            'status' => 'ACTIVE',
        ]);

        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(200)
            ->assertJsonPath('tree.health', 100);

        $tree->refresh();

        $this->assertEquals(100, $tree->health);
        $this->assertEquals(1, $tree->progress);
    }


    // PRUEBA 12: El cooldown debe durar exactamente 60 minutos
    public function test_next_care_is_exactly_sixty_minutes_later(): void
    {
        $user = User::factory()->create();

        $item = Item::create([
            'name' => 'Semilla para probar cooldown',
            'price' => 100,
            'item_type' => 'SEED',
        ]);

        $seedType = SeedType::create([
            'id_item' => $item->id_item,
            'name' => 'Arbol de tiempo',
            'cares_per_level' => 5,
            'harvest_reward' => 50,
        ]);

        $tree = Trees::create([
            'id_user' => $user->id_user,
            'id_seed_type' => $seedType->id_seed_type,
            'status' => 'ACTIVE',
        ]);

        $this->actingAs($user)
            ->postJson("/api/trees/{$tree->id_tree}/care")
            ->assertStatus(200);

        $tree->refresh();

        $this->assertNotNull($tree->last_cared_at);
        $this->assertNotNull($tree->next_care_at);

        $differenceInSeconds =
            $tree->next_care_at->getTimestamp()
            - $tree->last_cared_at->getTimestamp();

        $this->assertSame(3600, $differenceInSeconds);
    }
}
