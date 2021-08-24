# test-fullstack

## Como iniciar o projeto
 - Clone o repositório
   - `git clone https://github.com/jpizzribeiro/test-fullstack-andre.git`
 - Entre na pasta principal
   - `cd test-fullstack-andre`
 - Instale os containers
   - `docker-compose up -d`
 - Rode as migrations
   - `docker exec -it app vendor/bin/phinx migrate`
 - Entre pelo link em seu navegador
   - `http://localhost:8080`



# test-fullstack

## Como iniciar o projeto
 - Clone o repositório
   - `git clone https://github.com/jpizzribeiro/test-fullstack-andre.git`
 - Entre na pasta principal
   - `cd test-fullstack-andre`
 - Instale os containers
   - `docker-compose up -d`
 - Rode as migrations
   - `docker exec -it app vendor/bin/phinx migrate`
 - Entre pelo link em seu navegador
   - `http://localhost:8080`


### Para acessar os endpoints do backend. importe essas rotas no seu insomnia.
```
{"_type":"export","__export_format":4,"__export_date":"2021-08-24T13:11:05.153Z","__export_source":"insomnia.desktop.app:v2021.3.0","resources":[{"_id":"req_66d107ce276a4e8fb65f00afe06a0d7c","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810560131,"created":1629576532970,"url":"http://localhost:4747/users/index","name":"Index","description":"","method":"GET","body":{},"parameters":[],"headers":[],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA","disabled":false},"metaSortKey":-1629477489509.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"fld_730a0526c2034545ac2a868251ae4c74","parentId":"wrk_b840ab40a08d4da9837fdd8e110cc98b","modified":1629489851615,"created":1629489851615,"name":"teste fullstack","description":"","environment":{},"environmentPropertyOrder":null,"metaSortKey":-1629489851615,"_type":"request_group"},{"_id":"wrk_b840ab40a08d4da9837fdd8e110cc98b","parentId":null,"modified":1609855598753,"created":1609855598753,"name":"Insomnia","description":"","scope":"collection","_type":"workspace"},{"_id":"req_96be3b1e22844a998ed5a4de29e22f2a","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810564731,"created":1629582447299,"url":"http://localhost:4747/systemStatus","name":"getSystemStatus","description":"","method":"GET","body":{},"parameters":[],"headers":[],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA","disabled":false},"metaSortKey":-1629477489497,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_89c26ae480e24791ba47cf2674bc237a","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810604398,"created":1629581098356,"url":"http://localhost:4747/users/1","name":"GetUser","description":"","method":"GET","body":{},"parameters":[],"headers":[],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA"},"metaSortKey":-1629477489484.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_23922f08bd0e4db09244df27456ef494","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810490066,"created":1629557367953,"url":"http://localhost:4747/register","name":"Register","description":"","method":"POST","body":{"mimeType":"application/json","text":"{\n\t\"username\": \"ATCamposs\",\n\t\"email\": \"andre.tatibano@gmail.com\",\n\t\"password\": \"@eF7400313\",\n\t\"confirmPassword\": \"@eF7400313\"\n}"},"parameters":[],"headers":[{"name":"Content-Type","value":"application/json","id":"pair_236f1d60b60e4d44916f11dbe8fcb1c6"}],"authentication":{},"metaSortKey":-1629477489459.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_a27d66b699b64480a86615c23dbde9c2","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629750746327,"created":1629555562092,"url":"http://localhost:4747/login","name":"Login","description":"","method":"POST","body":{"mimeType":"application/json","text":"{\n\t\"email\": \"andre.tatibano@gmail.com\",\n\t\"password\": \"@eF7400313\"\n}"},"parameters":[],"headers":[{"name":"Content-Type","value":"application/json","id":"pair_236f1d60b60e4d44916f11dbe8fcb1c6"}],"authentication":{},"metaSortKey":-1629477489409.5,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_889188ea70764395b00ec9d3537c344f","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810540636,"created":1629574550369,"url":"http://localhost:4747/users/update","name":"Update","description":"","method":"POST","body":{"mimeType":"application/json","text":"{\n\t\"email\": \"ahasuhasuhsa@ashusau.com\"\n}"},"parameters":[],"headers":[{"name":"Content-Type","value":"application/json","id":"pair_236f1d60b60e4d44916f11dbe8fcb1c6"}],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA"},"metaSortKey":-1629457971263.875,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_e80965662d64481c9ef968bd15f6c717","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810547913,"created":1629634262801,"url":"http://localhost:4747/users/updatePassword","name":"UpdatePassword","description":"","method":"POST","body":{"mimeType":"application/json","text":"{\n\t\"password\": \"@eF7400313\",\n\t\"confirmPassword\": \"@eF7400313\"\n}"},"parameters":[],"headers":[{"name":"Content-Type","value":"application/json","id":"pair_236f1d60b60e4d44916f11dbe8fcb1c6"}],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA"},"metaSortKey":-1629448212191.0625,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"req_0ece7937cfa94198b59c1a3a00b5fc78","parentId":"fld_730a0526c2034545ac2a868251ae4c74","modified":1629810615171,"created":1629567332450,"url":"http://localhost:4747/users/delete/1","name":"Delete","description":"","method":"DELETE","body":{},"parameters":[],"headers":[],"authentication":{"type":"bearer","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2Mjk4MTA1MDgsImlzcyI6ImNydWRzaGVsbC5jb20iLCJleHAiOjE2MzAyNDI1MDgsIm5iZiI6MTYyOTgxMDUwNywiZGF0YSI6eyJpZCI6MSwidXNlcm5hbWUiOiJBVENhbXBvc3MifX0.g4czp4T7Z6pUNpb-sPIGZhaTgC-7q0mn5j2rWqtH-SA"},"metaSortKey":-1629438453118.25,"isPrivate":false,"settingStoreCookies":true,"settingSendCookies":true,"settingDisableRenderRequestBody":false,"settingEncodeUrl":true,"settingRebuildPath":true,"settingFollowRedirects":"global","_type":"request"},{"_id":"env_d1b97ec0a10a77db20500f934aae6468f75d589a","parentId":"wrk_b840ab40a08d4da9837fdd8e110cc98b","modified":1609855598805,"created":1609855598805,"name":"Base Environment","data":{},"dataPropertyOrder":null,"color":null,"isPrivate":false,"metaSortKey":1609855598805,"_type":"environment"},{"_id":"jar_d1b97ec0a10a77db20500f934aae6468f75d589a","parentId":"wrk_b840ab40a08d4da9837fdd8e110cc98b","modified":1629634373331,"created":1609855598808,"name":"Default Jar","cookies":[{"key":"PHPSID","value":"0b6254d18f48d84128f98fc8","domain":"localhost","path":"/","hostOnly":true,"creation":"2021-08-22T12:12:53.326Z","lastAccessed":"2021-08-22T12:12:53.326Z","id":"2774531491725072"}],"_type":"cookie_jar"},{"_id":"spc_dfa3a94e76234e79b8770b453ab97148","parentId":"wrk_b840ab40a08d4da9837fdd8e110cc98b","modified":1609855598754,"created":1609855598754,"fileName":"Insomnia","contents":"","contentType":"yaml","_type":"api_spec"},{"_id":"env_fbc0f242de1c40019c56f2e3d7abc26f","parentId":"env_d1b97ec0a10a77db20500f934aae6468f75d589a","modified":1629395936114,"created":1629395924828,"name":"controle fornecedores","data":{},"dataPropertyOrder":null,"color":null,"isPrivate":false,"metaSortKey":1629395924828,"_type":"environment"}]}
```