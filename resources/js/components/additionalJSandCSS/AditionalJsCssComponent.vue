<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="text-center">Выбрать необходимые Javascript файлы для этой страницы</p>
            </div>
        </div>
        <div class="row justify-content-lg-between">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 clearfix">
                <file-paths-component :files="filePs"></file-paths-component>
                <db-paths-component :dbpaths="dbPs"></db-paths-component>
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
        data(){
            return {
                filePs:[],
                dbPs:[],
            };
        },
        methods:{
            //Check an Array is an Array
            polyfillIsArray(){
                if (!Array.isArray) {
                    Array.isArray = function(arg) {
                      return Object.prototype.toString.call(arg) === '[object Array]';
                    };
                }
            },
            //Check incoming properties.
            checkProp(arr){
                if(Array.isArray(arr) && (arr.length !== 0)){
                    return arr;
                }else{
                    return [];
                }
            }
        },
        created(){
            //Let's launch the polyfill just in case
            this.polyfillIsArray();
            //Preparing incoming properties before transferring them to the children Components            
            this.filePs = this.checkProp(this.filePaths);
            this.dbPs = this.checkProp(this.dbPaths);
        },
        mounted() {
            //console.log('Component mounted.')
        }
    }
</script>
