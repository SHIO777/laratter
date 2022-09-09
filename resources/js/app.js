import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// 2022.09.09  add 削除前のalert機能
// https://qol-kk.com/wp2/blog/2019/03/28/post-1174/
function delete_alert(e) {
    if (!window.confirm('本当に削除しますか？')) {
        window.alert('キャンセルされました');
        return false;
    }
    document.deleteform.submit();
};