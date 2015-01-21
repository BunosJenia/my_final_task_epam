function getXHR(){
    var xmlhttp = false;
    var XMLHttpFactories = [
        function (){return new XMLHttpRequest()},
        function (){return new ActiveXObject("Msxml2.XMLHTTP")},
        function (){return new ActiveXObject("Msxml3.XMLHTTP")},
        function (){return new ActiveXObject("Microsoft.XMLHTTP")}];

    for(var i=0; i < XMLHttpFactories.length; i++){
        try{
            xmlhttp = XMLHttpFactories[i]();
        }
        catch (e){
            continue;
        }
        break
    }
    return xmlhttp;
}