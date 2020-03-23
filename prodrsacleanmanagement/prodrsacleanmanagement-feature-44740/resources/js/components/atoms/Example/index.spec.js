import { createLocalVue, mount } from '@vue/test-utils';
import Vuex from 'vuex';
import Example from '@/js/components/atoms/Example';

const localVue = createLocalVue();
localVue.use(Vuex);

test('it works', () => {
    expect(1 + 1).toBe(2)
});

describe('Example', () => {

    const props = {
        buttonName: 'ButtonName',
    };

    it('ボタンテキストが正しく表示されているか確認', () => {
    // propsを受け取り shallowMountし テスト対象component生成
        const wrapper = mount(Example, { propsData: { ...props } });

        // {{ name }}にpropsで受け取った値が表示されているか確認
        const el = wrapper.find('button');
        expect(el.text()).toBe(props.buttonName)

    });

    it('clickイベントの確認', () => {
    // propsを受け取り shallowMountし テスト対象component生成
        const wrapper = mount(Example, { propsData: { ...props } })

        // clickイベント実行
        wrapper.find('button').trigger('click');

        // Actionが実行されたか確認
        expect(wrapper.emitted('Action')).toBeTruthy();

    })

    it('is a Vue instance', () => {
        const wrapper = mount(Example, {
            localVue,
            propsData:{...props},
            mocks: {},
            stubs: {},
            methods: {}
        });
        expect(wrapper.isVueInstance()).toBeTruthy();
        expect(wrapper).toMatchSnapshot();
    });

});
