import Vaults from './Components/Vaults.vue';
import Tools from './Components/Tools.vue';
import VaultItemView from './Modules/Vaults/VaultModal.vue';
import NotFound from './Components/NotFound.vue';

export var routes = [
    {
        path: '/',
        name: 'vault',
        component: Vaults,
        meta: {
            active_menu: 'vault'
        }
    },
    {
        path: '/vault/item/edit:', 
        name:'VaultItemEdit', 
        component: VaultItemView
    },
    {
        path: '/tools',
        name: 'tools',
        component: Tools,
        meta: {
            active_menu: 'tools'
        }
    },
    { 
        path: '/:pathMatch(.*)*', 
        name: 'NotFound',
        component: NotFound 
    }
    
];

