import { clean } from "./plateSanitizer.js";


test('should not do anything if incorrect data type', () => {
    [null, undefined, 123, {}].forEach(async (val) => {
        expect(await clean(val)).toBe(val);
    })
});

test('should not change string if clean format', () => {
    [
        'DMM123',
        '1234AA',
        '123',
        'KW'
    ].forEach(async (val) => {
        expect(await clean(val)).toBe(val)
    });
});