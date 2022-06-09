import {isValid} from "./plateFormatValidator";

test('should not be valid if incorrect data type', async () => {
    expect(await isValid({})).toBe(false);
    expect(await isValid(1)).toBe(false);
    expect(await isValid(undefined)).toBe(false);
    expect(await isValid(null)).toBe(false);
    expect(await isValid(123)).toBe(false);
});

test('should not be valid if correct data type but has leading 0', async () => {
    expect(await isValid("S-DD0123")).toBe(false);
});

test('should not be valid if correct data type but wrong format', async () => {
    expect(await isValid("1234")).toBe(false);
    expect(await isValid("zzzzzzz")).toBe(false);
    expect(await isValid("!@#$%^&*()")).toBe(false);
    expect(await isValid("")).toBe(false);
    expect(await isValid("1-BB11")).toBe(false);
});

test('should be valid if correct data type and format', async () => {
    expect(await isValid("S-GT1234")).toBe(true);
    expect(await isValid("SA-GT234")).toBe(true);
    expect(await isValid("SAD-GT234")).toBe(true);
    expect(await isValid("S-GT234")).toBe(true);
    expect(await isValid("KW-G234")).toBe(true);
});