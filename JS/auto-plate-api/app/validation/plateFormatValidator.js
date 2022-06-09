// [a-zA-Z]{1,3}\-[a-zA-Z]{1,2}[1-9]{0,4}

const isValid = async (val) => {

    if (typeof (val) !== 'string') {
        return false;
    }

    return /^[a-zA-Z]{1,3}\-[a-zA-Z]{1,2}[1-9]{0,4}$/.test(val);
}

export { isValid }
