jest.mock('file-saver');
jest.mock('@/utils/wfs');
import FileSaver from 'file-saver';
import VwSiteExportDialogContent from '@/components/DataCard/ExportDialog/VwSiteExportDialogContent';
import {getFeatureQueryString, setWfsGetFeatureRequestHeaders} from '@/utils/wfs';
import {GET_GUEST_AUTH} from '@/store/geoserver/auth/getters';
import {getNamespacedStoreProp} from '../../../utils';
import {
    getVuetifyWrapper,
    catchLocalVueDuplicateVueBug,
    resetConsoleError,
} from '../../../components/utils';

let wrapper;
let mountOptions;

beforeAll(() => {
    catchLocalVueDuplicateVueBug();
});

afterAll(() => {
    resetConsoleError();
});

const getMountOptions = () => {
    return {
        $store: {
            state: {
                geoserver: {
                    baseUrl: 'http://geoserver.com/'
                }
            },
            getters: {
                [getNamespacedStoreProp('geoserver/auth', GET_GUEST_AUTH)]: 'mockedGuestAuth',
            }
        },
        computed: {
            getQueryFilter() {
                return jest.fn().mockReturnValue('mockedFilter');
            },
        },
        propsData: {
            modalProps: {
                typename: 'test:typename',
                queryTypename: 'test-query-typename'
            },
            isModalRequestPending: false
        }
    };
};

beforeEach(() => {
    mountOptions = getMountOptions();
    wrapper = getVuetifyWrapper(
        'shallowMount',
        VwSiteExportDialogContent,
        mountOptions
    );
});

describe('VwSiteExportDialogContent', () => {
    describe('computed', () => {
        it.each([
            ['kml', 'KML'],
            ['json', 'application/json'],
            ['gml3', 'GML3'],
            ['shp', 'shape-zip'],
            ['csv', 'CSV']
        ])('when "format" is %s then "outputFormat" is \'%s\'', (format, expected) => {
            wrapper.setData({format});
            expect(wrapper.vm.outputFormat).toBe(expected);
        });
        it.each([
            ['kml', 'kml'],
            ['json', 'json'],
            ['gml3', 'gml'],
            ['shp', 'zip'],
            ['csv', 'csv']
        ])('when "format" is %s then "downloadFileExtension" is \'%s\'', (format, expected) => {
            wrapper.setData({format});
            expect(wrapper.vm.downloadFileExtension).toBe(expected);
        });
        it('typename', () => {
            expect(wrapper.vm.typename).toBe('test:typename');
        });
        it('queryTypename', () => {
            expect(wrapper.vm.queryTypename).toBe('test-query-typename');
        });
    });
    describe('methods', () => {
        describe('"getUrl"', () => {
            it('calls "getQueryFilter" method with the expected "queryTypename"', () => {
                wrapper.vm.getUrl();
                expect(wrapper.vm.getQueryFilter).toHaveBeenCalledWith('test-query-typename');
            });
            it('calls "getFeatureQueryString" method with the expected args', () => {
                wrapper.vm.getUrl();
                expect(getFeatureQueryString).toHaveBeenCalledWith({
                    'contentDisposition': 'attachment',
                    'filter': 'mockedFilter',
                    'format': 'application/json',
                    'typename': 'test:typename'}
                );
            });
        });
        describe('"export"', () => {
            beforeEach(() => {
                setWfsGetFeatureRequestHeaders.mockReturnValue('mockedHeaders');
                wrapper.setMethods({
                    clientRequest: jest.fn().mockResolvedValue({data: {type: 'mocked/type'}}),
                    getUrl: jest.fn().mockReturnValue('mockedUrl')
                });
                wrapper.vm.export();
            });
            it('calls "getUrl"', () => {
                expect(wrapper.vm.getUrl).toHaveBeenCalled();
            });
            it('calls "setWfsGetFeatureRequestHeaders"', () => {
                expect(setWfsGetFeatureRequestHeaders).toHaveBeenCalledWith({}, 'mockedGuestAuth');
            });
            it('calls "axiosRequestConfig"', () => {
                expect(wrapper.vm.clientRequest).toHaveBeenCalledWith({
                    'headers': 'mockedHeaders',
                    'method': 'get',
                    'responseType': 'blob',
                    'url': 'mockedUrl',
                });
            });
            it('calls FileSaver.saveAs', () => {
                expect(FileSaver.saveAs).toHaveBeenCalledWith(new Blob(), 'archiraq_export.json', {'type': 'mocked/type'});
            });
            it('$emits update:isRequestPending twice', () => {
                let $emits = wrapper.emitted('update:isModalRequestPending');
                expect($emits).toHaveLength(2);
                expect($emits[0]).toEqual([true]);
                expect($emits[1]).toEqual([false]);
            });
        });
    });
});
