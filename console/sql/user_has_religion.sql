-- Menambahkan Foreign Key untuk religion_id di tabel user
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-religion_id`
        FOREIGN KEY (`religion_id`)
            REFERENCES `religion`(`id`)
            ON UPDATE CASCADE;