/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('fabu', function (success, error) {
    axios.get("/public/tpl/fatie.html").then(function (res) {
        success({
            template: res.data
        });
    });
});