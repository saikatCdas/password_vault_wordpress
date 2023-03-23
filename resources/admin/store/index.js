import {createLogger, createStore} from 'vuex';
import Rest from '../Bits/Rest';
const {get, post, put} = Rest;
const store = createStore({
    state:{
        user:{
            data: '',
            token: sessionStorage.getItem("TOKEN"),
          },
          notification: {
            show: false,
            type: 'success',
            message: ''
          },
          exportData:{},
          folders: [],
          vaultItems:{},
          vaultItem:{},
          paginationLinks:[]
    },
    getters:{},
    actions:{
        search({commit}, searchInp){
            return get(`search/${searchInp}`)
            .then((data)=>{
                commit('setVaultItems', data);
            });
        },
        import({commit}, data){
            return post('import', data);
        },
        moveFolder({commit}, data){
            return put('move-folder', data);
        },
        deleteSelectedVaultItem({commit}, itemId){
            return Rest.delete(`delete-selected-vault-item/${itemId}`);
        },
        getItem({commit}, id){
            return get(`get-item/${id}`)
                .then((data)=>{
                    commit('setVaultItem', data);
                })
        },
        getAllVault({commit}, {type, url}){

            //converting type into a string
            let queryString;
            if(!url){
                queryString = Object.keys(type).map(key => key + '=' + type[key]).join('&');
            }
            const encodedData = encodeURIComponent(JSON.stringify(queryString));
            // checking if request has url
            url = url || `get-all-vault/${encodedData}`
            return get(url)
                .then((data)=>{
                    commit('setVaultItems', data);
                });
        },

        // Create or Update Vault Item
        manageVault({commit}, vaultData){
            if(!vaultData.id){
                return post('create-vault', vaultData);
            }else{
                return put('update-vault', vaultData);
            }
        },
        getFolder({commit}){
            return get('get-folder')
                .then((data)=>{
                    commit('setFolderName', data)
                })
        },
        createFolder({commit}, folderName){
            return post('create-folder', {name:folderName})
                .then((data)=>{
                    commit('setFolderName', data);
                })
        },
        exportVault({commit}){
            return get('export')
                .then((res)=>{
                    // console.log(res.data);
                    const array = res
                    const header = Object.keys(array[0]).join(",");
                    const data = array.map(obj => {
                        return Object.values(obj).map(val => {
                          if (typeof val === "string") {
                            return `"${val.replace(/"/g, '""')}"`;
                          }
                          return val;
                        }).join(",");
                      }).join("\n");
                    
                    commit('setExportData', `${header}\n${data}`);
                    
                })
        },
    },
    mutations:{
        setVaultItem:(state, vaultItem) => {
            state.vaultItem = vaultItem;
        },
        setVaultItems:(state, allVaultData)=>{
            state.vaultItems = allVaultData.data;
            // state.paginationLinks = allVaultData.meta.links;
        },
        setFolderName:(state, data) => {
            state.folders = data ;
        },
        setExportData:(state, data) => {
            state.exportData = data;
        },
        setUser: (state, user) => {
            state.user.data = user;
        },
        setToken: (state, token) => {
            state.user.token = token;
            sessionStorage.setItem('TOKEN', token);
        },
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },
        notify: (state, {message, type}) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
              state.notification.show = false;
            }, 8000)
        },
    },
    modules:{}
})

export default store;