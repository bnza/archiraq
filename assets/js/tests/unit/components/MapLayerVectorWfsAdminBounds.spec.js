import MapLayerVectorWfsAdminBounds from '@/components/MapLayerVectorWfsAdminBounds';
import {getVuetifyWrapper} from '@tests/unit/components/utils';

describe('MapLayerVectorWfsAdminBounds', () => {
    describe('computed', () => {
        describe('"visible"', () => {
            it.each([
                ['the-right-cid', 'the-right-cid', true],
                ['the-right-cid', 'the-wrong-cid', false],
            ])('when "mapContainerAdminBounds" = "%s" and cid = "%s" getter returns \'%s\'', (mapContainerAdminBounds, cid, expected) => {
                const $this={
                    mapContainerAdminBounds,
                    cid
                };
                expect(MapLayerVectorWfsAdminBounds.computed.visible.get.apply($this)).toEqual(expected);
            });
            it('setter set truthy value', () => {
                const $this={
                    mapContainerAdminBounds: '',
                    cid: 'SomeAdminBounds'
                };
                MapLayerVectorWfsAdminBounds.computed.visible.set.apply($this, [true]);
                expect($this.mapContainerAdminBounds).toEqual($this.cid);
            });
            it.each([
                ['SomeAdminBounds', ''],
                ['SomeOtherBounds', 'SomeOtherBounds'],
                ['', ''],
            ])('setter set falsy value when "mapContainerAdminBounds" = "%s"', (mapContainerAdminBounds, expected) => {
                const $this={
                    mapContainerAdminBounds,
                    visible: mapContainerAdminBounds === 'SomeAdminBounds'
                };
                MapLayerVectorWfsAdminBounds.computed.visible.set.apply($this, [false]);
                expect($this.mapContainerAdminBounds).toEqual(expected);
            });
        });

    });
});
