import {defineStore} from 'pinia'
import axios from 'axios'

export const useUpdateUserStore = defineStore('userUpdateStore',{
state:()=>({
    user:[],
    selectedUser:null
}),
actions:{
    async updateUser(user){
        try{
            user
            const response = await axios.put('http://127.0.0.1:8000/api/users');
            this.users = response.data;

        }catch(error){
            console.error("Error retrieving users:",error)
        }
    },
    setSelectedUser(user){
        this.selectedUser = user;
    }
}
})