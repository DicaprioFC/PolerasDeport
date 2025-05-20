<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $productos = [

            ["nombre" => "Polera Nike", "precio" => 399, "marca" => "Nike", "imagen" => "imagenes/n1.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Liverpool", "precio" => 299, "marca" => "Nike", "imagen" => "imagenes/n3.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Paris", "precio" => 399, "marca" => "Nike", "imagen" => "imagenes/n4.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Barcelona", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/n5.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Liverpool", "precio" => 299, "marca" => "Nike", "imagen" => "imagenes/m13.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike de la selección de Brasil", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/n6.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike de la selección de Brasil", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/n7.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike de la selección de Francia", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/n8.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Tottenham", "precio" => 399, "marca" => "Nike", "imagen" => "imagenes/n9.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Chelsea", "precio" => 299, "marca" => "Nike", "imagen" => "imagenes/n10.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike de la selección de Países Bajos", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/n11.png", "id_usuario" => 1],
            ["nombre" => "Polera Nike del Inter de Milán", "precio" => 399, "marca" => "Nike", "imagen" => "imagenes/n12.png", "id_usuario" => 1],
            //["nombre" => "Polera de precalentamiento de Portugal", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/nike21.png", "id_usuario" => 1],
            //["nombre" => "Segunda equipación de Portugal", "precio" => 499, "marca" => "Nike", "imagen" => "imagenes/nike22.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de Portugal", "precio" => 599, "marca" => "Nike", "imagen" => "imagenes/nike23.png", "id_usuario" => 1],
            //["nombre" => "Polera de Portugal", "precio" => 299, "marca" => "Nike", "imagen" => "imagenes/nike24.png", "id_usuario" => 1],


            ["nombre" => "Polera del Real Madrid", "precio" => 299, "marca" => "Adidas", "imagen" => "imagenes/a1.png", "id_usuario" => 1],
            ["nombre" => "Polera del Inter de Miami", "precio" => 199, "marca" => "Adidas", "imagen" => "imagenes/a2.png", "id_usuario" => 1],
            ["nombre" => "Primera equipación del Real Madrid", "precio" => 299, "marca" => "Adidas", "imagen" => "imagenes/a3.png", "id_usuario" => 1],
            ["nombre" => "Polera del Manchester United", "precio" => 120, "marca" => "Adidas", "imagen" => "imagenes/a4.png", "id_usuario" => 1],
            ["nombre" => "Polera del Bayern Múnich", "precio" => 130, "marca" => "Adidas", "imagen" => "imagenes/a5.png", "id_usuario" => 1],
            ["nombre" => "Polera del Arsenal", "precio" => 100, "marca" => "Adidas", "imagen" => "imagenes/adidas20.png", "id_usuario" => 1],
            ["nombre" => "Segunda equipación del Arsenal", "precio" => 100, "marca" => "Adidas", "imagen" => "imagenes/adidas21.png", "id_usuario" => 1],
            ["nombre" => "Primera equipación del Bayern Múnich", "precio" => 199, "marca" => "Adidas", "imagen" => "imagenes/adidas22.png", "id_usuario" => 1],
            ["nombre" => "Segunda equipación del Bayern Múnich", "precio" => 110, "marca" => "Adidas", "imagen" => "imagenes/adidas23.png", "id_usuario" => 1],
            ["nombre" => "Polera de la Juventus", "precio" => 120, "marca" => "Adidas", "imagen" => "imagenes/adidas24.png", "id_usuario" => 1],
            ["nombre" => "Primera equipación de la Juventus", "precio" => 199, "marca" => "Adidas", "imagen" => "imagenes/adidas25.png", "id_usuario" => 1],
            ["nombre" => "Primera equipación de Alemania", "precio" => 499, "marca" => "Adidas", "imagen" => "imagenes/adidas27.png", "id_usuario" => 1],
            //["nombre" => "Segunda equipación de España", "precio" => 499, "marca" => "Adidas", "imagen" => "imagenes/adidas28.png", "id_usuario" => 1],
            //["nombre" => "Segunda equipación de Alemania", "precio" => 100, "marca" => "Adidas", "imagen" => "imagenes/adidas26.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de Argentina", "precio" => 499, "marca" => "Adidas", "imagen" => "imagenes/adidas29.png", "id_usuario" => 1],
            //["nombre" => "Segunda equipación de Argentina", "precio" => 499, "marca" => "Adidas", "imagen" => "imagenes/adidas30.png", "id_usuario" => 1],



            ["nombre" => "Polera Marathon de Oriente", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m1.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Oriente cuello V", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m2.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Strongest", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m3.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Strongest cuello V", "precio" => 399, "marca" => "Marathon", "imagen" => "imagenes/m4.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Blooming", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m5.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Always Ready", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m6.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Aurora", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/m7.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Royal Pari", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/m8.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de la selección de Bolivia", "precio" => 499, "marca" => "Marathon", "imagen" => "imagenes/m9.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de la selección de Ecuador", "precio" => 399, "marca" => "Marathon", "imagen" => "imagenes/m10.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Always Ready cuello V", "precio" => 199, "marca" => "Marathon", "imagen" => "imagenes/m11.png", "id_usuario" => 1],
            ["nombre" => "Polera Marathon de Aurora cuello redondo", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/m12.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de Always Ready", "precio" => 120, "marca" => "Marathon", "imagen" => "imagenes/marathon20.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de Blooming", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/marathon21.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de The Strongest", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/marathon22.png", "id_usuario" => 1],
            //["nombre" => "Primera equipación de la selección boliviana", "precio" => 299, "marca" => "Marathon", "imagen" => "imagenes/marathon23.png", "id_usuario" => 1],






            ["nombre" => "TENIS NIKE", "precio" => 250, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE1.png", "id_usuario" => 1],
            ["nombre" => "MERCURIAL CHUTERAS", "precio" => 500, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE2.png", "id_usuario" => 1],
            ["nombre" => "CHUTERAS NIKE", "precio" => 450, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE3.png", "id_usuario" => 1],
            ["nombre" => "SHORT DEPORTIVO NIKE", "precio" => 150, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE4.png", "id_usuario" => 1],
            ["nombre" => "POLERA DEPORTIVA NIKE", "precio" => 399, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE5.png", "id_usuario" => 1],
            ["nombre" => "MEDIAS NIKE", "precio" => 99, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE6.png", "id_usuario" => 1],
            ["nombre" => "POLERA NIKE CASUAL", "precio" => 299, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE7.png", "id_usuario" => 1],
            ["nombre" => "POLERA NIKE", "precio" => 299, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE8.png", "id_usuario" => 1],
            ["nombre" => "CHINELAS NIKE", "precio" => 199, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE9.png", "id_usuario" => 1],
            ["nombre" => "SHORT NIKE", "precio" => 299, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE10.png", "id_usuario" => 1],
            ["nombre" => "POLERA DEPORTIVA NIKE DEL PARIS", "precio" => 499, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE11.png", "id_usuario" => 1],
            ["nombre" => "POLERA DEL PARIS", "precio" => 399, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE12.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL ATLETICO DE MADRID", "precio" => 499, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE32.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL ATLETICO DE MADRID", "precio" => 499, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE31.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL PARIS", "precio" => 399, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE33.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL TOTTENHAM", "precio" => 499, "marca" => "MarcaNike", "imagen" => "imagenes/NIKE34.png", "id_usuario" => 1],



            ["nombre" => "POLERA DE BOLIVIA", "precio" => 199, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA1.png", "id_usuario" => 1],
            ["nombre" => "POLERA DE BLOMMING", "precio" => 499, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA2.png", "id_usuario" => 1],
            ["nombre" => "POLERA DE STRONGEST", "precio" => 399, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA3.png", "id_usuario" => 1],
            ["nombre" => "POLERA DE ORIENTE", "precio" => 399, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA4.png", "id_usuario" => 1],
            ["nombre" => "SHORT MARATHON", "precio" => 120, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA5.png", "id_usuario" => 1],
            ["nombre" => "SOLERA DE ENTRENAMIENTO", "precio" => 150, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA6.png", "id_usuario" => 1],
            ["nombre" => "TENIS DE ENTRENAMIENTO", "precio" => 299, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA7.png", "id_usuario" => 1],
            ["nombre" => "TENIS", "precio" => 199, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA8.png", "id_usuario" => 1],
            ["nombre" => "TENIS MARATHON", "precio" => 299, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA9.png", "id_usuario" => 1],
            ["nombre" => "TENIS CASUAL", "precio" => 299, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA10.png", "id_usuario" => 1],
            ["nombre" => "SHORT DE ENTRENAMIENTO", "precio" => 120, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA11.png", "id_usuario" => 1],
            ["nombre" => "CONJUNTO COMPLETO", "precio" => 1500, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA12.png", "id_usuario" => 1],
            //["nombre" => "ROMPE VIENTO DE LA SELECCION", "precio" => 1100, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA31.png", "id_usuario" => 1],
            //["nombre" => "ROMPE VIENTO DE ORIENTE", "precio" => 999, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA32.png", "id_usuario" => 1],
            //["nombre" => "ROMPE VIENTO DE STRONGEST", "precio" => 999, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA33.png", "id_usuario" => 1],
            //["nombre" => "ROMPE VIENTO DE BLOMMING", "precio" => 999, "marca" => "MarcaMarathon", "imagen" => "imagenes/MARA34.png", "id_usuario" => 1],



            ["nombre" => "POLERA DE BOLIVAR", "precio" => 499, "marca" => "Otras", "imagen" => "imagenes/NIDEA3 (1).png", "id_usuario" => 1],
            ["nombre" => "POLERA JORDAN", "precio" => 199, "marca" => "Otras", "imagen" => "imagenes/OTRO1.png", "id_usuario" => 1],
            ["nombre" => "JORDAN DEPORTIVA", "precio" => 299, "marca" => "Otras", "imagen" => "imagenes/OTRO2.png", "id_usuario" => 1],
            ["nombre" => "SUDADERA NIKE", "precio" => 250, "marca" => "Otras", "imagen" => "imagenes/OTRO3.png", "id_usuario" => 1],
            ["nombre" => "JORDAN", "precio" => 1800, "marca" => "Otras", "imagen" => "imagenes/OTRO4.png", "id_usuario" => 1],
            ["nombre" => "JORDAN ROJOS", "precio" => 1099, "marca" => "Otras", "imagen" => "imagenes/OTRO5.png", "id_usuario" => 1],
            ["nombre" => "SHORT", "precio" => 199, "marca" => "Otras", "imagen" => "imagenes/OTRO6.png", "id_usuario" => 1],
            ["nombre" => "JORDAN BLANCOS", "precio" => 1500, "marca" => "Otras", "imagen" => "imagenes/OTRO 7.png", "id_usuario" => 1],
            ["nombre" => "JORDAN V", "precio" => 1099, "marca" => "Otras", "imagen" => "imagenes/OTRO8.png", "id_usuario" => 1],
            ["nombre" => "SUDADERA", "precio" => 299, "marca" => "Otras", "imagen" => "imagenes/otra10.png", "id_usuario" => 1],
            ["nombre" => "POLERA", "precio" => 99, "marca" => "Otras", "imagen" => "imagenes/otra11.png", "id_usuario" => 1],
            ["nombre" => "POLERA ULTIMA EDICION", "precio" => 120, "marca" => "Otras", "imagen" => "imagenes/otra12.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL MANCHESTER CITY", "precio" => 499, "marca" => "Otras", "imagen" => "imagenes/OTRA31.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL BORUCIA DORMUND", "precio" => 199, "marca" => "Otras", "imagen" => "imagenes/OTRA32.png", "id_usuario" => 1],
            //["nombre" => "POLERA DEL MILAN", "precio" => 399, "marca" => "Otras", "imagen" => "imagenes/OTRA33.png", "id_usuario" => 1],
            //["nombre" => "SEGUNDA EQUIPACION DEL BOLIVAR", "precio" => 199, "marca" => "Otras", "imagen" => "imagenes/OTRA34.png", "id_usuario" => 1],
        ];


        DB::table('productos')->insert($productos);
    }
}
