/* global global */
import {getMapPixelHeight, arrayHasIndex, getStatusText, getStatusColor, getStatusIcon, getProgressPercentage, getJobProgressPercentage} from '@/utils/utils';

describe('"getMapPixelHeight"', () => {
    it('returns default value if "isFullScreen" flag is false', () => {
        expect(getMapPixelHeight(false)).toEqual('500px');
    });
    it('returns computed value if "isFullScreen" flag is true', () => {
        global.innerHeight = 800;
        expect(getMapPixelHeight(true)).toEqual('700px');
    });

});

describe('"arrayHasIndex"', () => {
    it('returns "true" when array has given integer index', () => {
        expect(arrayHasIndex([false, 9], 0)).toEqual(true);
    });
    it('returns "false" when array hasn\'t given integer index', () => {
        expect(arrayHasIndex([false, 9], 4)).toEqual(false);
    });
    it('returns "true" when array has given array indexes', () => {
        expect(arrayHasIndex([false, 9], [0,1])).toEqual(true);
    });
    it('returns "false" when array hasn\'t given array indexes', () => {
        expect(arrayHasIndex([false, 9], [1,7])).toEqual(false);
    });
});

describe('"getStatusText"', () => {
    it.each([
        [{isRunning: true}, 'RUNNING'],
        [{isError: true}, 'ERROR'],
        [{isCancelled: true}, 'CANCELLED'],
        [{isSuccessful: true}, 'SUCCESS']
    ])('getStatusText(%o) returns \'%s\'' , (status, expected) => {
        expect(getStatusText(status)).toEqual(expected);
    });
});

describe('"getStatusColor"', () => {
    it.each([
        [{isRunning: true}, 'indigo darken2'],
        [{isError: true}, 'red darken2'],
        [{isCancelled: true}, 'red darken2'],
        [{isSuccessful: true}, 'green darken2']
    ])('getStatusColor(%o) returns \'%s\'' , (status, expected) => {
        expect(getStatusColor(status)).toEqual(expected);
    });
});

describe('"getStatusIcon"', () => {
    it.each([
        [{isRunning: true}, 'settings_backup_restore'],
        [{isError: true}, 'error_outline'],
        [{isCancelled: true}, 'highlight_off'],
        [{isSuccessful: true}, 'check_circle_outline']
    ])('getStatusIcon(%o) returns \'%s\'' , (status, expected) => {
        expect(getStatusIcon(status)).toEqual(expected);
    });
});

describe('"getProgressPercentage"', () => {
    it.each([
        [{currentStepNum: 1, stepsNum: 10}, 2, '10.00'],
        [{currentStepNum: 2, stepsNum: 3}, 4, '66.6667'],
    ])('getProgressPercentage(%o, %i) returns \'%s\'' , (runnable, precision, expected) => {
        expect(getProgressPercentage(runnable, precision)).toEqual(expected);
    });
});

describe('"getJobProgressPercentage"', () => {
    it.each([
        [{status: {isSuccessful: true}}, 4, '100.0000'],
        [{currentStepNum: 1, stepsNum: 4, tasks: [null,{currentStepNum: 1, stepsNum: 6}]}, 2, '29.17'],
    ])('getJobProgressPercentage(%o, %i) returns \'%s\'' , (job, precision, expected) => {
        expect(getJobProgressPercentage(job, precision)).toEqual(expected);
    });
});
