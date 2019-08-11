import DataCardTableRowMx from '@/mixins/DataCardTableRowMx';

describe('DataCardTableRowMx', () => {
    describe('methods', () => {
        it.each([
            [[{value:'a'}, {value:'b'}], 'b', true],
            [[{value:'a'}, {value:'b'}], 'c', false],
            [[], 'a', false],
        ])('%j.headersHaveElement(\'%s\') returns %s', (headers, value, expected) => {
            const $this = {
                headers
            };
            expect(DataCardTableRowMx.methods.headersHaveElement.apply($this, [value])).toEqual(expected);
        });
    });
});
