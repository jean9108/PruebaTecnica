<?php

use yii\db\Migration;

/**
 * Class m190918_030834_sql
 */
class m190918_030834_sql extends Migration
{
    /* ============================================================
      ====================== Base de datos =========================
     ============================================================ */

    public function safeUp()
    {
        //Tabla hoteles
        $this->createTable('hoteles',[
            'id_hotel' =>$this->primaryKey(),
            'nombre' => $this->string(45)->notNull(),
            'nit' => $this->string(10)->notNull(),
            'direccion' => $this->string(45)->notNull(),
            'num_habitaciones' => $this->integer(5)->notNull(),
            'estado' => $this->string(8)->notNull()->defaultValue('Activo'),
        ]);
        
        //Tabla Habitaciones
        $this->createTable('habitaciones',[
            'id_habitacion' => $this->primaryKey(),
            'habitacion' =>$this->string(45)->notNull()->unique(),
            'estado' => $this->string(8)->notNull()->defaultValue('Activo'),
        ]);

        //Tabla Acomodaciones
        $this->createTable('acomodaciones',[
            'id_acomodacion' => $this->primaryKey(),
            'acomodacion' =>$this->string(45)->notNull()->unique(),
            'estado' => $this->string(8)->defaultValue('Activo'),
        ]);

        //Tabla Tipo_Habitaciones
        $this->createTable('tipo_habitaciones',[
            'id_tipo' => $this->primaryKey(),
            'id_habitacion' => $this->integer(),
            'id_acomodacion' => $this->integer(),
            'estado' => $this->string(8)->notNull()->defaultValue('Activo'),
        ]); 

        //Tabla asignacion_habitaciones
        $this->createTable('asignacion_habitaciones',[
            'id_asignacion' => $this->primaryKey(),
            'id_tipo' => $this->integer()->notNull(),
            //'id_acomodacion' => $this->integer()->notNull(),
            'estado' => $this->string(8)->notNull()->defaultValue('Activo'),
        ]);

        /*====== LLaves Foraneas =======*/
        //1. Tipo_habitaciones
        $this->addForeignKey(
            'fk-tipo_habitaciones-id_habitacion',
            'tipo_habitaciones',
            'id_habitacion',
            'habitaciones',
            'id_habitacion',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tipo_habitaciones-id_acomodacion',
            'tipo_habitaciones',
            'id_acomodacion',
            'acomodaciones',
            'id_acomodacion',
            'CASCADE'
        );

        //2. asignacion_habitaciones
        $this->addForeignKey(
            'fk-asignacion_habitaciones-id_tipo',
            'asignacion_habitaciones',
            'id_tipo',
            'tipo_habitaciones',
            'id_tipo',
            'CASCADE'
        );

    }

    /* ============================================================
      ===================== Borrado de tablas =====================
     ============================================================ */
    public function safeDown()
    {
        $this->dropTable('asignacion_habitaciones');
        $this->dropTable('tipo_habitaciones');
        $this->dropTable('habitaciones');
        $this->dropTable('acomodaciones');
        $this->dropTable('hoteles');
    }
}