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
                    },
                    order: '最新',
                    remen: {
                        'background': 'rgba(255, 80, 80, 0.8)',
                        'color': '#fff'
                    }
                    ,
                    zuixin: {
                        'background': 'rgba(61, 191, 255, 0.8)',
                        'color': '#fff'
                    }

                }
            },
            methods: {
                getData: function (type = 1) {
                    $this = this;
                    axios.get('/wx/articel', {
                        params: {
                            cate: 0,
                            page: this.page,
                            click_count: this.order == '热门' ? 0 : 1
                        }
                    }).then(function (res) {
                        if(type == 1){
                            $this.tiezi = $this.tiezi.concat(res.data.list.data);
                        }else{
                            $this.page = 1;
                            $this.tiezi = res.data.list.data;
                        }
                        $this.load = false;
                    });

                },
                touchStart: function (e) {
                    console.log('touchStart');

                    this.move = 0;
                    this.styles.transition = 'transform 0s';
                    this.touchStartY = e.changedTouches[0].clientY;
                },
                touchMove: function (e) {
                    console.log('touchMove');

                    this.move = e.changedTouches[0].clientY - this.touchStartY;
                    this.styles.transform = 'translateY(' + this.move + 'px)';
                },
                touchEnd: function (e) {
                    console.log('touchEnd');

                    if (this.move > 75) {
                        this.page = 1;
                        this.tiezi = [];
                        this.getData();
                    }
                    this.styles.transition = 'transform 0.5s'
                    this.styles.transform = 'translateY(0px)';
                },
                onScroll: function (e) {

                    let bottom = $('#tabbar1')[0].scrollHeight - $('#tabbar1')[0].scrollTop - $('#tabbar1')[0].offsetHeight;
                    console.log($('#tabbar1')[0].scrollTop);
                    console.log('bottom');
                    if (this.lastBottom > bottom && bottom < $('#tabbar1')[0].clientHeight / 3 && this.load) {
                        this.page++;
                        this.getData();
                        this.lastBottom = bottom;
                    }
                },
                getComment: function (item) {
                    id = item.id;
                    router.push({
                        path: '/pinglun/' + id,
                    })
                },
                setZan: function (item) {
                    zan = !!!item.zanLog ? 1 : -1;
                    id = item.id;
                    axios.post('wx/articel_zan', {
                        id: id,
                        zan: zan
                    }).then(function (res) {
                        item.zan = res.data.articel.zan;
                    });
                    item.zanLog = !!!item.zanLog;
                },
                orderConvert(){
                    this.order = this.order == '热门' ? '最新' : '热门';
                    this.getData(0);
                }
            },
            mounted (){
                this.getData();
            }
        });
    });
});