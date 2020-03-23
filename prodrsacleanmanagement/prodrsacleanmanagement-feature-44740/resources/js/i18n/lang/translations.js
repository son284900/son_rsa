import en from './translations_en'
import ja from './translations_ja'

// 複数言語の辞書をマージ
var data = Object.assign(en, ja)
export { data }
