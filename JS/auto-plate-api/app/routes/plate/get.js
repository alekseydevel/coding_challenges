import Router from 'express-promise-router';
import { repo } from '../../db/repository.js';

const router = new Router();

router.get('/plate', async (req, res) => {
    res.send(JSON.stringify(await repo.findAll(req.query['q'])))
})

export { router }