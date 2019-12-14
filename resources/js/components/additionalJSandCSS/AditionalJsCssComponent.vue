<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="text-center">Выбрать необходимые Javascript файлы для этой страницы</p>
            </div>
        </div>
        <div class="row justify-content-lg-between">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 clearfix">
                <file-paths-component :files="filePaths"></file-paths-component>
                <db-paths-component :dbpaths="dbPaths"></db-paths-component>
            </div>
        </div>
    </div>
</template>
<script>
import FilePathsComponent from "./FilePathsJsCssComponent.vue";
import DbPathsComponent from "./DbPathsJsCssComponent.vue";
    export default {
        props:["filePaths","dbPaths"],
        components:{
            filePathsComponent: FilePathsComponent,
            dbPathsComponent: DbPathsComponent
        },
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
