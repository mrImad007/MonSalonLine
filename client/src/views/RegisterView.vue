<script setup>
import BaseHeader from  "../components/BaseHeader.vue"
import Swal from 'sweetalert2'




const register = async(e)=>{
    // console.log(e.target);
    // const form = e.target;
    const myFormData = new FormData(e.target);
    const response = await fetch("http://localhost:8001/api/customer/register",{
        method: 'POST',
        headers: {
        },
        body: myFormData
    });
    const data = await response.json()
    // console.log(data);
    // console.log(response.status);
    if(response.status ===  201){
        // you need to store his referance on cookie so he can register in all website 
        // push to customer his code reference so he can login anytime 
        // router.push("/");
        console.log(data)
        Swal.fire(
            "Your Account Have been Created \n this is your login Reference :" + data.Customer_reference
        );
    }
    else{
        
        // messageError.value = data.message ;
    }
    
}
</script>


<template>
    <div >
        <BaseHeader/>
        <div class="main-register">
            <div class="cover">
                <img src="https://cdn.pixabay.com/photo/2016/06/12/21/41/barber-1453064_1280.jpg" alt="">
            </div>
            <form action="" @submit.prevent="register">
                <div class="register-form">
                    <h1 class=". text-4xl">
                        Create your Account 
                    </h1>
                    <div class="input max-w-lg">
                        <label for="FirstName">FirstName</label>
                        <div class="input-value">
                            <input type="text" name="FirstName" placeholder="First Name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="LastName">LastName</label>
                        <div class="input-value">
                            <input type="text" name="LastName" placeholder="Last Name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="Email">Email</label>
                        <div class="input-value">
                            <input type="Email" name="Email" placeholder="email@gmail.com" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="PhoneNumber">PhoneNumber</label>
                        <div class="input-value">
                            <input type="Number" name="PhoneNumber" placeholder="0650423607" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="Address">Address</label>
                        <div class="input-value">
                            <input type="text" name="Address" placeholder="AnyAddresse 2235 AnyState 3365" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="City">City</label>
                        <div class="input-value">
                            <input type="text" name="City" placeholder="New York" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                    <div class="input max-w-lg">
                        <label for="State">State</label>
                        <div class="input-value">
                            <input type="text" name="State" placeholder="AnyState" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="text-red-600"></span>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 rounded shadow-orange-100 px-2 py-2 text-white hover:bg-blue-600 mb-4">
                    Create An Account 
                </button>
            </form>
        </div>
    </div>
</template>


<style scoped>

.main-register{
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 20px;
    height: 90vh;

}

.cover{
    height: 100%;
    
}

.input{
    margin : 1rem 0;
}
.cover img{
    height: 100%;
    object-fit: cover;
}
form{
    margin: auto;
    min-width: 400px;
}

@media (max-width:700px) {
    .main-register{
        grid-template-columns: repeat(1,1fr);
    
    }
}

</style>
