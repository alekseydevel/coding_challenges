const clean = async (val) => {

    if (typeof(val) !== 'string') {
        return val;
    }

    return val.replace(/[^a-zA-Z0-9]/g, "");
}

export {clean}