/**
 * Created by Administrator on 2017/11/30.
 */
tiezi = Vue.component('tiezi', function (success, error) {
    axios.get("/public/tpl/index.html").then(function (res) {
        success({
            template: res.data,
            data(){
                return {
                    tiezi: [],
                    load: true,
                    lastBottom: 9999,
                    page: 1,
                    touchStartY: 0,
                    styles: {
                        transform: 'translateY(0px)'
                    }
                }
            },
            methods: {
                getData: function () {
                    $this = this;
                    axios.get('/wx/articel', {params: {cate: 0, page: this.page}}).then(function (res) {

                        $this.tiezi = $this.tiezi.concat(res.data.list.data);
                    });
                },
                touchStart: function (e) {
                    this.touchStartY = e.changedTouches[0].clientY;
                },
                touchMove: function (e) {
                    console.log(e.changedTouches[0].clientY);
                    this.move = e.changedTouches[0].clientY - this.touchStartY;
                    this.styles.transform = 'translateY('+this.move+'px)';
                },
                touchEnd: function (e) {
                    this.styles.transform = 'translateY(0px)';
                    console.log('touchend');
                },
                onScroll: function (e) {
                    let bottom = $('#scrollPanel')[0].scrollHeight - $('#scrollPanel')[0].scrollTop - $('#scrollPanel')[0].offsetHeight

                    if (this.lastBottom > bottom && bottom < $('#scrollPanel')[0].clientHeight / 3 && this.load) {
                        this.page++;
                        this.getData();
                        this.load = false;
                        this.lastBottom = bottom;
                    }
                }
            },
            mounted (){
                this.getData();
            }
        });
    });
});