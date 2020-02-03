const routes = require('./routes.json');

//Arguments: 1. Route name, 2. Route arguments if they are needed
// route('home') or route('home',['1']) or route("admin.scripts.destroy",[3])
export default function(){
        //let args = [].slice.call(arguments);
        //let args = Array.from(arguments);
        //let args = [...arguments];
        //Create copy of the real array based on arguments. args - "route name",[id]
        let args = Array.prototype.slice.call(arguments);
        //Get route name, the array is reduced by one element. Leave only [id] in args.
        let name = args.shift();
        //routes["admin.scripts.destroy"] - return "admin\/scripts\/{script}" - Method destroy
        if(routes[name] === undefined){
            console.log("Route is absant");
        }else{//Route presents
            let uriPart =  '/' + routes[name].split('/').map(str=>{
                //Check first character of an element
                if(str[0] == '{'){//If character is a curly bracket, set second parameter from args - [id]
                   return args.shift();
               }else{
                   return str;
               }
           }).join('/');
           return window.location.protocol+"//"+window.location.hostname + uriPart;
        }
};