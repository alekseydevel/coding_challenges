import { client } from './client.js';
import { clean } from '../service/plateSanitizer.js';

const repo = {
    async findAll(search = "") {

        search = await clean(String(search));

        let query = 'SELECT * from plates';

        if (search) {
            query = `SELECT * from plates WHERE levenshtein(plate_clean, '${search}') <= 1`;
        }

        const rows = await client.query(query);

        return rows.rows || [];
    },

    // todo: create-update-delete shouldn't live in repo.
    async createPlate(plate = "") {
        const text = 'INSERT INTO plates(plate, plate_clean, timestamp) VALUES($1, $2, $3)';
        await client.query(text, [plate, await clean(plate), '2022-01-01 01:01:01']);
    },
}

export { repo };