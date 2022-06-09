const f = async (req, res, next) => {

    if (! ('plate' in req.body)) {
        res.status(400).send({
            "message": "`plate` param must be set"
        });

        return;
    }

    next();
}

export { f }