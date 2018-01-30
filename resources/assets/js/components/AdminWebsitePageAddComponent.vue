<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <template v-if="!isEditing">Создание</template><template v-if="isEditing">Редактирование</template> страницы для сайта {{website.domain}}</div>
                    <div class="panel-body" v-if="isLoading">
                        Идет обработка данных...пиу-пиу
                    </div>
                    <div class="panel-body" v-if="!isLoading">
                        <form class="form-horizontal" onsubmit="return false;">
                            <div class="form-group">
                                <label for="title" class="col-sm-4 control-label">Заголовок страницы</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="title" placeholder="Главная" v-model="page.title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slug" class="col-sm-4 control-label">ЧПУ страницы</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="slug" placeholder="glavnaya" v-model="page.slug">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="menu_position" class="col-sm-4 control-label">Позиция в меню</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="menu_position" placeholder="4" v-model="page.menu_position">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-sm-4 control-label">Текст страницы</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="content" :rows="30" v-model="page.content"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-success btn-sm" @click="save()">
                                        <template v-if="!isEditing">Создать страницу</template><template v-if="isEditing">Сохранить изменения</template>
                                    </button>
                                    <a class="btn btn-info" :href="'/admin/website/' + websiteId + '/page/add'">Create another page</a>
                                    <a class="btn btn-default" :href="'/admin/website/' + websiteId + '/page/list'">Return to page list</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['pageId','websiteId'],
        data() {
            return {
                isEditing: false,
                isLoading: false,
                website: {
                    id: null,
                    name: null,
                    domain: null,
                    template_id: null
                },
                page: {
                    id: null,
                    title: null,
                    slug: null
                }
            }
        },
        methods: {
            save: function () {
                let _this = this;
                _this.isLoading = true;
                if(_this.isEditing) {
                    axios.put('/api/page/', {page: _this.page}).then(function (r) {
                        if(r.data.success) {
                            alert('success');
                        }
                        else {
                            alert('error');
                        }
                        _this.isLoading = false;
                    }).catch(function (e) {
                        alert('fail');
                        _this.isLoading = false;
                    });
                } else {
                    _this.page.website_id = _this.websiteId;
                    axios.post('/api/page/', {page: _this.page}).then(function (r) {
                        if(r.data.success) {
                            alert('success');
                            location.href = r.data.redirectUrl;
                        }
                        else {
                            alert('error');
                        }
                        _this.isLoading = false;
                    }).catch(function (e) {
                        alert('fail');
                        _this.isLoading = false;
                    });
                }
            },
        },
        created() {
            let _this = this;
            if(_this.pageId !== undefined) {
                _this.isEditing = true;
                axios.get('/api/page/' + _this.pageId).then(function (res) {
                    _this.page = res.data.page;
                });
            }
            axios.get('/api/website/get/' + _this.websiteId).then(function (res) {
                _this.website = res.data.website;
            });
        },
        mounted() {
        }
    }
</script>
