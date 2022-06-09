import { isValid } from "../validation/plateFormatValidator.js";

const f = async (req, res, next) => {

    const plate = req.body['plate'] || null;

    if (! await isValid(plate)) {
        res.status(422).send({
            "message": "Bad format for `plate` param"
        });

        return;
    }

    next();
}

export { f }