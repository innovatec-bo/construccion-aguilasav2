<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Usuario Super admin original
        // User::create([
        //     'first_name' => 'Jair',
        //     'last_name' => 'Cussy',
        //     'email' => 'jair@twiiti.com',
        //     'password' => bcrypt('12345678')
        // ])->assignRole('Super admin');

        // Lista de usuarios adicionales con rol "User"
        $users = [
            ['Alejandro', 'Toyama', 'alejandro.ta@gmail.com'],
            ['Andres', 'Delgadillo', 'adelgadillo@mailinator.com'],
            ['Anibal', 'Guaman', 'aguaman@mailinator.com'],
            ['Carlos', 'Garcia', 'carlosagad@cre.com.bo'],
            ['Christian', 'Villavicencio', 'christianvr@cre.com.bo'],
            ['Cruztel', 'Gir 1', 'cruztelgir1@mail.com'], // Reemplazado serebo.com por mail.com
            ['Cruztel', 'Gir 2', 'cruztelgir2@mail.com'], // Reemplazado serebo.com por mail.com
            ['Cruztel', 'Gis 2', 'cruztelgis2@mail.com'], // Reemplazado serebo.com por mail.com
            ['Cruztel-2', '', 'cruztel-2@mailinator.com'],
            ['Dario', 'Flores', 'dariojfm@cre.com.bo'],
            ['Diego', 'Suarez', 'diegoasr@cre.com.bo'],
            ['Erlin', 'Alcoba', 'erlinac@cre.com.bo'],
            ['Fernando', 'Sandoval', 'fsandoval@mailinator.com'],
            ['Herman', 'Velasco flores', 'hermanvf@cre.com.bo'],
            ['Javier', 'Vidal', 'javiervm@cre.com.bo'],
            ['Jhonny', 'Velarde', 'jhonyvv@cre.com.bo'],
            ['Jorge', 'Justiniano', 'jjustiniano@mailinator.com'],
            ['Jose Ovidio', 'salvatierra', 'joseosy@cre.com.bo'],
            ['Jose lider', 'Rodriguez soliz', 'joselrs@cre.com.bo'],
            ['Jose luis', 'Ramirez', 'josers@cre.com.bo'],
            ['Juan carlos', 'Giles', 'juancgh@cre.com.bo'],
            ['Juan carlos', 'Molina', 'juancmg@cre.com.bo'],
            ['Layonel', 'Lujan', 'layonelrln@cre.com.bo'],
            ['Lorgio', 'Coca', 'lorgiocc@cre.com.bo'],
            ['Luis', 'Duran', 'luisdf@cre.com.bo'],
            ['Luis alberto', 'Pereyra salame', 'luisalberto@mail.com'], // Reemplazado serebo.com por mail.com
            ['Mario diego', 'Galvarro', 'mariodgr@cre.com.bo'],
            ['Milton', 'Madrid', 'miltonmr@cre.com.bo'],
            ['Milton', 'Ruiz', 'miltonro@cre.com.bo'],
            ['Oreste', 'Rodriguez', 'oresterb@cre.com.bo'],
            ['Oswaldo', 'Ontiveros', 'reneoom@cre.com.bo'],
            ['Pablo', 'Vaca', 'pablopdvm@gmail.com'],
            ['Pablo ariel', 'Mendoza villa', 'pablo.a.mendoza.v@gmail.com'],
            ['Paul', 'Rojas', 'paulrs@cre.com.bo'],
            ['Ricardo', 'Claure', 'rclaure@cruztel.com'],
            ['Roberto', 'Morales', 'robertomm@cre.com.bo'],
            ['Rolando', 'Delgadillo', 'rolandodc@cre.com.bo'],
            ['Salvio', 'Cegarra', 'salviocm@cre.com.bo'],
            ['Santiago', 'Sardina', 'santiagojse@cre.com.bo'],
            ['Santos', 'Cespedes', 'santosbcg@cre.com.bo'],
            ['Sergio', 'Medina', 'sergiommp@cre.com.bo'],
            ['Víctor mauricio', 'Miranda vargas', 'victormmv@cre.com.bo'],
            ['Vitalio', 'Dorado', 'darwindm@cre.com.bo'],
            ['Walter', 'Añez', 'walterag@cre.com.bo'],
            ['Yhory miguel', 'Mamani gavincha', 'yhorym@mail.com'], // Reemplazado serebo.com por mail.com
        ];

        foreach ($users as [$firstName, $lastName, $email]) {
            // Regla de contraseña: a12345 + 1ra letra mayúscula + 2da letra minúscula + *
            // Limpiamos espacios o caracteres especiales si el primer nombre fuera compuesto o extraño
            $cleanName = preg_replace('/[^a-zA-Z]/', '', $firstName);
            $firstLetter = strtoupper(substr($cleanName, 0, 1));
            $secondLetter = strtolower(substr($cleanName, 1, 1));
            
            $rawPassword = 'a12345' . $firstLetter . $secondLetter . '*';

            User::create([
                'firstname_usr' => $firstName,
                'lastname_usr'  => $lastName,
                'email_usr'     => $email,
                'email'         => $email, // Incluido para que Laravel pueda autenticar sin problemas
                'password_usr'  => bcrypt($rawPassword),
                'password'      => bcrypt($rawPassword), // Por compatibilidad estándar con Auth si lo requiere
            ])->assignRole(['User','Fiscal de CRE']);
        }

        // Ejecutar el comando artisan solicitado
        Artisan::call('serebo:sync-roles');
    }
}