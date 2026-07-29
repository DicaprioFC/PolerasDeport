<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CarritoReleaseTest extends TestCase
{
    use RefreshDatabase;

    private function crearProducto(
        User $propietario,
        int $stock = 10
    ): Producto {
        return Producto::create([
            'nombre' => 'Polera de prueba',
            'precio' => 499.00,
            'marca' => 'LF-Store',
            'imagen' => 'imagenes/prueba.png',
            'oferta' => false,
            'descuento' => null,
            'id_usuario' => $propietario->id,
            'stock' => $stock,
        ]);
    }

    public function test_producto_sin_stock_no_puede_agregarse_al_carrito(): void
    {
        $propietario = User::factory()->create();
        $cliente = User::factory()->create();

        $producto = $this->crearProducto($propietario, 0);

        $response = $this
            ->actingAs($cliente)
            ->post(route('carrito.agregar', $producto->id));

        $response
            ->assertRedirect()
            ->assertSessionHas(
                'error',
                'El producto no tiene stock disponible.'
            );

        $this->assertDatabaseMissing('carrito', [
            'user_id' => $cliente->id,
            'producto_id' => $producto->id,
        ]);
    }

    public function test_no_se_puede_superar_el_stock_disponible(): void
    {
        $propietario = User::factory()->create();
        $cliente = User::factory()->create();

        $producto = $this->crearProducto($propietario, 1);

        $this
            ->actingAs($cliente)
            ->post(route('carrito.agregar', $producto->id))
            ->assertRedirect();

        $response = $this
            ->actingAs($cliente)
            ->post(route('carrito.agregar', $producto->id));

        $response
            ->assertRedirect()
            ->assertSessionHas(
                'error',
                'No puedes agregar una cantidad mayor al stock disponible.'
            );

        $this->assertDatabaseHas('carrito', [
            'user_id' => $cliente->id,
            'producto_id' => $producto->id,
            'cantidad' => 1,
        ]);
    }

    public function test_carrito_vacio_no_inicia_pago_paypal(): void
    {
        $cliente = User::factory()->create();

        $response = $this
            ->actingAs($cliente)
            ->post(route('carrito.paypal'));

        $response
            ->assertRedirect(route('carrito.mostrar'))
            ->assertSessionHas('error', 'El carrito está vacío.');

        $this->assertDatabaseCount('ventas', 0);
    }

    public function test_usuario_no_puede_consultar_venta_de_otro_usuario(): void
    {
        // El primer usuario representa al administrador con ID 1.
        User::factory()->create();

        $propietario = User::factory()->create();
        $otroUsuario = User::factory()->create();

        $ventaId = DB::table('ventas')->insertGetId([
            'user_id' => $propietario->id,
            'total' => 499.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this
            ->actingAs($otroUsuario)
            ->get(route('carrito.exito', ['venta' => $ventaId]))
            ->assertForbidden();
    }

    public function test_pago_cancelado_conserva_el_carrito(): void
    {
        $propietario = User::factory()->create();
        $cliente = User::factory()->create();

        $producto = $this->crearProducto($propietario, 10);

        DB::table('carrito')->insert([
            'user_id' => $cliente->id,
            'producto_id' => $producto->id,
            'cantidad' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this
            ->actingAs($cliente)
            ->withSession([
                'paypal_order_id' => 'ORDER-TEST-001',
                'paypal_user_id' => $cliente->id,
                'paypal_total_bs' => 499.00,
                'paypal_total_usd' => 71.70,
                'paypal_currency' => 'USD',
            ])
            ->get(route('paypal.cancelado'));

        $response
            ->assertRedirect(route('carrito.mostrar'))
            ->assertSessionHas(
                'error',
                'Pago cancelado. El carrito se mantiene disponible.'
            )
            ->assertSessionMissing('paypal_order_id')
            ->assertSessionMissing('paypal_user_id')
            ->assertSessionMissing('paypal_total_bs');

        $this->assertDatabaseHas('carrito', [
            'user_id' => $cliente->id,
            'producto_id' => $producto->id,
            'cantidad' => 1,
        ]);

        $this->assertDatabaseCount('ventas', 0);
    }
}