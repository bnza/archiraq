import JobStatusRefresher from '@/components/JobStatusRefresher';

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
    const data = {data: require('../../cypress/fixtures/archiraq/job/status/e6243678_1')};
    clientRequest = jest.fn().mockResolvedValueOnce(data);
    clientXsrfRequest = jest.fn();
    return {
        propsData: {
            id: 'some-id'
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
        JobStatusRefresher,
        mountOptions
    );
};

describe('JobStatusRefresher', () => {
    describe('lifecycle', () => {
        beforeEach(baseSetup);
        describe('mounted', () => {
            it('"job" property is set', () => {
                expect(clientRequest).toHaveBeenCalledWith({'method': 'get', 'url': '/job/some-id/status'});
                expect(wrapper.vm.job).toBeTruthy();
            });
        });
    });
    describe('watch', () => {

        describe('"id"', () => {
            beforeEach(baseSetup);
            it('"job" property is refreshed', done => {
                const data = {data: require('../../cypress/fixtures/archiraq/job/status/e6243678_1')};
                clientRequest.mockResolvedValueOnce(data);
                wrapper.setProps({id: 'new-id'});
                wrapper.vm.$nextTick(() => {
                    expect(clientRequest).toHaveBeenLastCalledWith({'method': 'get', 'url': '/job/new-id/status'});
                    done();
                });
            });
        });
        describe('"job"', () => {
            it.skip('"job" property is refreshed while job is running', (done) => {
                const data1 = {data: require('../../cypress/fixtures/archiraq/job/status/e6243678_1')};
                const data2 = {data: require('../../cypress/fixtures/archiraq/job/status/e6243678_2')};
                let clientRequest2 = jest.fn()
                    .mockResolvedValueOnce(data1)
                    .mockResolvedValue(data2);
                let mountOptions2 = {
                    propsData: {
                        id: 'some-id'
                    },
                    methods: {
                        clientRequest2
                    }
                };

                wrapper = getVuetifyWrapper(
                    'shallowMount',
                    JobStatusRefresher,
                    mountOptions2
                );

                setTimeout(() => {
                    expect(clientRequest).toHaveBeenCalledTimes(2);
                    done();
                }, 600);
            });
        });
    });
});
