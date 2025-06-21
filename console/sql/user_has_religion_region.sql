-- Menambahkan Foreign Key untuk religion_id di tabel user
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-religion_id`
        FOREIGN KEY (`religion_id`)
            REFERENCES `religion`(`id`)
            ON UPDATE CASCADE;

-- Menambahkan Foreign Key untuk province_code di tabel user
-- Asumsi: Kolom 'kode' di tabel 'region' adalah primary key atau unique index
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-province`
        FOREIGN KEY (`province_code`)
            REFERENCES `region`(`kode`)
            ON UPDATE CASCADE;

-- Menambahkan Foreign Key untuk regency_code di tabel user
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-regency`
        FOREIGN KEY (`regency_code`)
            REFERENCES `region`(`kode`)
            ON UPDATE CASCADE;

-- Menambahkan Foreign Key untuk district_code di tabel user
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-district`
        FOREIGN KEY (`district_code`)
            REFERENCES `region`(`kode`)
            ON UPDATE CASCADE;

-- Menambahkan Foreign Key untuk village_code di tabel user
ALTER TABLE `user`
    ADD CONSTRAINT `fk-user-village`
        FOREIGN KEY (`village_code`)
            REFERENCES `region`(`kode`)
            ON UPDATE CASCADE;