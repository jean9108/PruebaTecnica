<?php

use yii\db\Migration;


class m190918_043916_poblacion_tablas_foraneas extends Migration
{
    /* ============================================================
    ====================== Poblacion de tablas ==================
    ============================================================ */
    public function safeUp()
    {
         //Poblacion Tabla tipo_habitaciones
         $this->insert('tipo_habitaciones', [
            'id_habitacion' => 1,
            'id_acomodacion' =>1
        ]);

        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 1,
            'id_acomodacion' =>2
        ]);

        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 2,
            'id_acomodacion' =>3
        ]);

        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 2,
            'id_acomodacion' =>4
        ]);

        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 3,
            'id_acomodacion' =>1
        ]);
        
        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 3,
            'id_acomodacion' =>2
        ]);

        $this->insert('tipo_habitaciones', [
            'id_habitacion' => 3,
            'id_acomodacion' =>3
        ]);

    }

    /* ============================================================
      ============ Eliminacion de datos de tablas ================
     ============================================================ */
    public function safeDown()
    {
        $this->delete('tipo_habitaciones');
    }
}
