<?php

use yii\db\Migration;

/**
 * Class m190918_040726_poblacion_tablas
 */
class m190918_040726_poblacion_tablas extends Migration
{
    /* ============================================================
      ====================== Poblacion de tablas ==================
     ============================================================ */
    public function safeUp()
    {
        //Poblacion Tabla Habitaciones
        $this->insert('habitaciones', [
            'habitacion' => 'Estandar',
        ]);

        $this->insert('habitaciones', [
            'habitacion' => 'Junior',
        ]);

        $this->insert('habitaciones', [
            'habitacion' => 'Suite',
        ]);

        
        //Poblacion Tabla Acomodaciones
        $this->insert('acomodaciones', [
            'acomodacion' => 'Sencilla',
        ]);

        $this->insert('acomodaciones', [
            'acomodacion' => 'Doble',
        ]);

        $this->insert('acomodaciones', [
            'acomodacion' => 'Triple',
        ]);

        $this->insert('acomodaciones', [
            'acomodacion' => 'Cuadruple',
        ]);
    }

    /* ============================================================
      ============ Eliminacion de datos de tablas ================
     ============================================================ */
    public function safeDown()
    {
        $this->delete('habitaciones');
        $this->delete('acomodaciones');
    }
}
