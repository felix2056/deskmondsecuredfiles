<template>
    <tr class="Maths">
        <th scope="row" class="d-none d-md-table-cell"><span :class="'badge '+data.subject">{{data.subject}}</span>
        </th>
        <td>
            <router-link :to="{name: 'create-class', query: { class_id: data.id }}">
                {{ data.title }}
            </router-link>
        </td>
        <td class="d-none d-md-table-cell">{{data.startDate | formatdate}}</td>
        <td class="d-none d-md-table-cell">{{data.submissionDate | formatdate}}</td>
    </tr>
</template>

<script>
import moment from 'moment';

export default {
    name:"Techclass",
    props:['data'],
    filters:{'formatdate':function(value){
            if(value){
                return moment(String(value)).format('LL')
            }
        }
    },
    data(){
        return{
            startDate:'',
            submissionDate:'',
        }
    },

    methods: {
        openClassDetail(docID){
            //this method will store the classdetail id and call the create/edit details.
            // this.$store.dispatch('setClassID', docID);
            
            this.$router.push({name: 'create-class', params: { id: docID }});
        }
    }
}
</script>