import Router from 'express-promise-router';
import { f as maskValidator } from '../../middleware/validPlateMaskValidator.js';
import { f as requestValidator } from '../../middleware/createPlateRequestValidator.js';
import { repo } from '../../db/repository.js';

const router = new Router();

router.post('/plate', requestValidator, maskValidator, async (req, res) => {

    if (!req.body) {
        res.status(400);
        res.end("Bad body");
        return;
    }

    const plate = req.body['plate'];

    if (!plate) {
        res.status(400);
        res.end("Bad parameter");
        return;
    }

    repo.
        createPlate(plate).
        then(() => {
            res.status(201);
            res.send('ok');
        }).
        catch(err => {
            console.log(err.stack)
            res.status(500).end();
            return;
        });

})

export { router }