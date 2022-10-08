<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateUnregisteredDevicesLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (Schema::connection('traccar_mysql')->hasTable('unregistered_devices_log')) { return; }

		Schema::connection('traccar_mysql')->create('unregistered_devices_log', function(Blueprint $table)
		{
			$table->string('imei', 50)->unique();
			$table->integer('port')->nullable();
			$table->string('ip', 50)->nullable();
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->index();
			$table->integer('times')->unsigned()->default('1');
		});

		DB::connection('traccar_mysql')->statement("
			CREATE TABLE application_settings (
		  id bigint(20) NOT NULL,
		  registrationEnabled tinyint(1) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

		DB::connection('traccar_mysql')->statement("
			CREATE TABLE devices (
		  id bigint(20) NOT NULL,
		  name varchar(255) DEFAULT NULL,
		  uniqueId varchar(255) DEFAULT NULL,
		  latestPosition_id bigint(20) DEFAULT NULL,
		  lastValidLatitude double DEFAULT NULL,
		  lastValidLongitude double DEFAULT NULL,
		  other text CHARACTER SET utf8mb4,
		  speed decimal(8,2) DEFAULT NULL,
		  time datetime DEFAULT NULL,
		  server_time datetime DEFAULT NULL,
		  ack_time datetime DEFAULT NULL,
		  altitude double DEFAULT NULL,
		  course double DEFAULT NULL,
		  power double DEFAULT NULL,
		  address varchar(500) CHARACTER SET utf8mb4 DEFAULT NULL,
		  protocol varchar(20) DEFAULT NULL,
		  latest_positions varchar(500) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");

		DB::connection('traccar_mysql')->statement("
			CREATE TABLE devices_fake (
			  uniqueId varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

		DB::connection('traccar_mysql')->statement("
			CREATE TABLE user (
		  id int(11) NOT NULL,
		  name varchar(128) NOT NULL,
		  email varchar(128) NOT NULL,
		  hashedPassword varchar(128) NOT NULL,
		  salt varchar(128) NOT NULL DEFAULT '',
		  readonly bit(1) NOT NULL DEFAULT b'0',
		  admin bit(1) NOT NULL DEFAULT b'0',
		  map varchar(128) DEFAULT NULL,
		  language varchar(128) DEFAULT NULL,
		  distanceUnit varchar(128) DEFAULT NULL,
		  speedUnit varchar(128) DEFAULT NULL,
		  latitude float NOT NULL DEFAULT '0',
		  longitude float NOT NULL DEFAULT '0',
		  zoom int(11) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

		DB::connection('traccar_mysql')->statement("
			CREATE TABLE user_device (
			  userId int(11) NOT NULL,
			  deviceId int(11) NOT NULL,
			  `read` int(1) NOT NULL DEFAULT '1',
			  `write` int(1) NOT NULL DEFAULT '1'
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE application_settings
		  ADD PRIMARY KEY (id);
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE devices
		  ADD PRIMARY KEY (id),
		  ADD UNIQUE KEY uniqueId (uniqueId),
		  ADD KEY time (time),
		  ADD KEY FK5CF8ACDD7C6208C3 (latestPosition_id),
		  ADD KEY server_time (server_time),
		  ADD KEY ack_time (ack_time);
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE user
		  ADD PRIMARY KEY (id),
		  ADD UNIQUE KEY email (email);
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE user_device
		  ADD KEY deviceId (deviceId),
		  ADD KEY user_device_userId (userId);
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE devices
		  MODIFY id bigint(20) NOT NULL AUTO_INCREMENT;
		");

		DB::connection('traccar_mysql')->statement("
			ALTER TABLE user
		  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
		");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::connection('traccar_mysql')->statement('DROP TABLE unregistered_devices_log');
		DB::connection('traccar_mysql')->statement('DROP TABLE devices');
		DB::connection('traccar_mysql')->statement('DROP TABLE application_settings');
		DB::connection('traccar_mysql')->statement('DROP TABLE devices_fake');
		DB::connection('traccar_mysql')->statement('DROP TABLE user');
		DB::connection('traccar_mysql')->statement('DROP TABLE user_device');
	}

}
