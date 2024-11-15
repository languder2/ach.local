<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
class CreateEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'uid'           => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
            ],
            'surname'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'username'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'email'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'phone'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'faculty'       => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
            ],
            'speciality'    => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
            ],
            'message'       => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'created_at'    => [
                'type'              => 'DATETIME',
                "default"           => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at'    => [
                'type'              => 'DATETIME',
                'default'           => new RawSql('CURRENT_TIMESTAMP'),
                'on_update'         => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('faculty', 'faculties', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('speciality', 'specialities', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('uid', 'users', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
