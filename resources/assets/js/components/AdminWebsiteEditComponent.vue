<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Редактирование вебсайта #{{website.id}}</div>
                    <div class="panel-body" v-if="isLoading">
                        Идет обработка данных...пиу-пиу
                    </div>
                    <div class="panel-body" v-if="!isLoading">
                        <form class="form-horizontal" onsubmit="return false;">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Название компании</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="name" placeholder="Сайт ООО Петрушка" v-model="website.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="domain" class="col-sm-2 control-label">Домен сайта</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="domain" placeholder="site.site" v-model="website.domain">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_publish" class="col-sm-2 control-label">Публикованный?</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="is_publish" v-model="website.is_publish">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template" class="col-sm-2 control-label">Шаблон</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="template" v-model="website.template_id">
                                </div>
                            </div>
                            <div>
                                <h4>Страницы сайта</h4>
                                <table class="table table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Позиция</th>
                                        <th>Заголовок</th>
                                        <th>ЧПУ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="page in website.pages">
                                        <td>{{page.menu_position}}</td>
                                        <td>{{page.title}}</td>
                                        <td>{{page.slug}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3">
                                            <button type="button" class="btn btn-info btn-sm" @click="regeneratePages()">Сгенерировать страницы</button>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-success btn-sm" @click="save()">Сохранить</button>
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
        props: ['websiteId'],
        data() {
            return {
                isLoading: true,
                website: {
                    id: null
                }
            }
        },
        methods: {
            save: function () {
                let _this = this;
                _this.isLoading = true;
                axios.post('/api/website/save/' + _this.website.id, {website: _this.website}).then(function (r) {
                    if(r.data.success) {
                        _this.isLoading = false;
                        _this.website = r.data.website;
                    }
                }).catch(function () {
                    _this.isLoading = false;
                });
            },
            regeneratePages: function () {
                let _this = this;
                _this.isLoading = true;
                axios.get('/api/website/regenerate/pages/' + _this.website.id).then(function (r) {
                    if(r.data.success) {
                        _this.isLoading = false;
                        _this.website = r.data.website;
                    }
                }).catch(function () {
                    _this.isLoading = false;
                });
            }
        },
        created() {
            let _this = this;
            _this.website.id = _this.websiteId;
            _this.isLoading = true;
            axios.get('/api/website/get/' + _this.website.id).then(function (r) {
                if(r.data.success) {
                    _this.isLoading = false;
                    _this.website = r.data.website;
                }
            }).catch(function () {

            });
        },
        mounted() {
        }
    }
</script>
