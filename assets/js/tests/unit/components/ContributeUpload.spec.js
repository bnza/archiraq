import FileSaver from 'file-saver';

jest.mock('file-saver');
import ContributeUpload from '@/components/ContributeUpload';
import {getDataTestSelector} from '@tests/unit/utils';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
} from '../components/utils';

let wrapper;
let mountOptions;
let clientRequest;
let clientXsrfRequest;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const getMountOptions = () => {
    clientRequest = jest.fn().mockResolvedValueOnce({data: 1234});
    clientXsrfRequest = jest.fn();
    return {
        propsData: {
            type: 'some-type',
            format: 'the-format'
        },
        methods: {
            clientRequest,
            clientXsrfRequest
        }
    };
};

const baseSetup = () => {
    mountOptions = getMountOptions();
    wrapper = getVuetifyWrapper(
        'shallowMount',
        ContributeUpload,
        mountOptions
    );
};

describe('ContributeUpload', () => {
    describe('components', () => {
        beforeEach(baseSetup);
        it('title should be set as expected', () => {
            const selector = getDataTestSelector('contribute-upload-title');
            expect(wrapper.find(selector).text()).toEqual('Some Type The Format contribute upload');
        });
    });
    describe('lifecycle', () => {
        beforeEach(baseSetup);
        describe('mounted', () => {
            it('contributeId is set', () => {
                expect(clientRequest).toHaveBeenCalledWith({'method': 'get', 'url': '/job/id/generate'});
                expect(wrapper.vm.contributeId).toEqual(1234);
            });
        });
    });
    describe('methods', () => {
        beforeEach(baseSetup);
        it('"getContributeDraftErrors"', (done) => {
            clientRequest.mockResolvedValueOnce({data: {value: 'some-data', type: 'some/type'}});
            wrapper.vm.getContributeDraftErrors().then(() => {
                expect(FileSaver.saveAs).toHaveBeenCalledWith(new Blob(), 'validationErrors.csv', {'type': 'some/type'});
                done();
            });
        });
        describe('upload', () => {
            it('finally set request pending', (done) => {
                clientXsrfRequest.mockReturnValue(new Promise((resolve) => {
                    resolve({data: {}});
                }));
                wrapper.vm.upload().then(() => {
                    expect(wrapper.vm.isRequestPending).toBeFalsy();
                    done();
                });
            });
            it('when ', (done) => {
                const getContributeDraftErrors = jest.fn();
                wrapper.setMethods({getContributeDraftErrors});
                clientXsrfRequest.mockReturnValue(new Promise((resolve, reject) => {
                    reject({
                        response: {
                            data: {
                                errors: 'Draft validation failed'
                            }
                        }
                    });
                }));
                wrapper.vm.upload().finally(() => {
                    expect(getContributeDraftErrors).toHaveBeenCalled();
                    done();
                });
            });
        });

    });
});
