import axios from 'axios';
import Client from '../../../../src/utils/geoserver/restClient';

jest.mock('axios');

beforeEach(() => {
    // Clear all instances and calls to constructor and all methods:
    axios.mockClear();
});

describe('constructor', () => {
    test.each([
        ['baseUrl', {}, 'http://example.com:8080/auth/'],
        ['username', {auth: 'dummyuser:password'}, 'dummyuser'],
        ['username', {auth: 'ZHVtbXl1c2VyOnBhc3N3b3Jk'}, 'dummyuser'],
        ['securityServices', {securityServices: {userGroup: 'ugss', roles: 'rss'}}, {userGroup: 'ugss', roles: 'rss'}]
    ])(
        'set prop "%s"',
        (prop, config, expected) => {
            const client = new Client('http://example.com:8080', config);
            expect(client[prop]).toEqual(expected);
        }
    );
});

describe('isServerRunning', () => {
    it ('Is true on successful response', async () => {
        expect.assertions(1);
        axios.request.mockResolvedValue({
            status: 200
        });
        const client = new Client('http://example.com:8080');
        expect(client.isServerRunning()).resolves.toBe(true);
    });
    it ('Is throws on http error', async () => {
        expect.assertions(1);
        const error = new Error('Non HTTP error');
        error.response = {
            status: 401,
            statusText: 'Full authentication is required to access this resource'
        };
        axios.request.mockRejectedValue(error);
        const client = new Client('http://example.com:8080');
        await expect(client.isServerRunning()).rejects.toEqual(
            new Error(
                'Server is running but you got: 401: Full authentication is required to access this resource. Check your server settings'
            )
        );
    });
    it ('It returns false on HTTP error', async () => {
        expect.assertions(1);
        const error = new Error('Non HTTP error');
        error.request = {};
        axios.request.mockRejectedValue(error);
        const client = new Client('http://example.com:8080');
        await expect(client.isServerRunning()).resolves.toBe(false);
    });
    it ('It throws on non http error', async () => {
        expect.assertions(1);
        const error = new Error('Non HTTP error');
        axios.request.mockRejectedValue(error);
        const client = new Client('http://example.com:8080');
        await expect(client.isServerRunning()).rejects.toEqual(error);
    });
});

describe('getUserGroups', () => {
    test.each([
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups/>',
            []
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>group1</group></groups>',
            ['group1']
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>group1</group><group>group2</group></groups>',
            ['group1', 'group2']
        ]
    ])(
        '%s',
        async (xml, expected) => {
            expect.assertions(1);
            axios.request.mockResolvedValue({
                data: xml,
                status: 200
            });
            const client = new Client('http://example.com:8080', {
                securityServices: {
                    userGroup: 'archiraq_user_group_service'
                },
                auth: 'dummy:pw'
            });
            let actual = await client.getUserGroups('username');
            expect(actual).toEqual(expected);
        }
    );
});

describe('getUserRoles', () => {
    describe('mergeGroupsRoles = false', () => {
        test.each([
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles/>',
                []
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_ADMIN</role></roles>',
                ['ROLE_ADMIN']
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_ADMIN</role><role>ROLE_CUSTOM</role></roles>',
                ['ROLE_ADMIN', 'ROLE_CUSTOM']
            ]
        ])(
            '%s',
            async (xml, expected) => {
                expect.assertions(1);
                axios.request.mockResolvedValue({
                    data: xml,
                    status: 200
                });
                const client = new Client('http://example.com:8080', {
                    securityServices: {
                        role: 'archiraq_role_service'
                    },
                    auth: 'dummy:pw'
                });
                let actual = await client.getUserRoles('username');
                expect(actual).toEqual(expected);
            }
        );
    });

    describe('mergeGroupsRoles = true', () => {
        test.each([
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles/>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups/>',
                []
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_ADMIN</role></roles>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups/>',
                ['ROLE_ADMIN']
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles/>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>editors</group><groups/>',
                ['ROLE_EDITOR']
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_EDITOR</role></roles>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>editors</group><groups/>',
                ['ROLE_EDITOR']
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_ADMIN</role><role>ROLE_CUSTOM</role></roles>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>editors</group><groups/>',
                ['ROLE_ADMIN', 'ROLE_CUSTOM', 'ROLE_EDITOR']
            ],
            [
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><roles><role>ROLE_EDITOR</role><role>ROLE_CUSTOM</role></roles>',
                '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>editors</group><groups/>',
                ['ROLE_EDITOR', 'ROLE_CUSTOM']
            ]
        ])(
            '%s',
            async (rolesXml, groupsXml, expected) => {
                expect.assertions(1);
                axios.request.mockResolvedValueOnce({
                    data: rolesXml,
                    status: 200
                });
                axios.request.mockResolvedValueOnce({
                    data: groupsXml,
                    status: 200
                });
                const client = new Client('http://example.com:8080', {
                    securityServices: {
                        roles: 'archiraq_role_service',
                        userGroup: 'archiraq_role_service'
                    },
                    auth: 'dummy:pw'
                });
                let actual = await client.getUserRoles('username', true);
                expect(actual).toEqual(expected);
            }
        );
    });
});

describe('getUserGroupsRoles', () => {
    test.each([
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups/>',
            []
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>group1</group></groups>',
            []
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>group1</group><group>guests</group></groups>',
            ['ROLE_GUEST']
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>administrators</group></groups>',
            ['ROLE_ADMIN']
        ],
        [
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><groups><group>administrators</group><group>editors</group><group>users</group><group>guests</group></groups>',
            ['ROLE_ADMIN', 'ROLE_EDITOR', 'ROLE_USER', 'ROLE_GUEST']
        ]
    ])(
        '%s',
        async (xml, expected) => {
            expect.assertions(1);
            axios.request.mockResolvedValue({
                data: xml,
                status: 200
            });
            const client = new Client('http://example.com:8080', {
                securityServices: {
                    userGroup: 'archiraq_user_group_service'
                },
                auth: 'dummy:pw'
            });
            let actual = await client.getUserGroupsRoles('username');
            expect(actual).toEqual(expected);
        }
    );
});