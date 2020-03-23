/**
 * Created by TAP Co.,Ltd .
 * User: m_oshiro
 * Date: 2020/03/03
 */

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import { data } from '@/js/i18n/lang/translations.js';

Vue.use(VueI18n);

/**
 *  locale : デフォルト言語設定
 *  fallbackLocale : 該当リソース無しの場合の言語設定
 */
const i18n = new VueI18n({
  locale: 'ja',
  fallbackLocale: 'en',
  messages: data
});
  
export default i18n;