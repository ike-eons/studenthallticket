<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="row text-center">
                            <h3 class="px-4 font-weight-bold text-info text-center">STUDENT'S PROFILE</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive">
                                 <tr>
                                     <td class=" text-right font-weight-bold text-muted">INDEX NO. : </td>
                                     <td class="pl-2">ANU16280180</td>
                                 </tr>
                                 <tr>
                                     <td class=" text-right font-weight-bold text-muted">NAME : </td>
                                     <td class="pl-2">FRIMPONG KWAME BAAH</td>
                                 </tr>
                                <tr>
                                     <td class=" text-right font-weight-bold text-muted">DEPARTMENT : </td>
                                     <td class="pl-2">COMPUTER SCIENCE & ENGINEERING</td>
                                </tr>
                                <tr>
                                     <td class=" text-right font-weight-bold text-muted">COURSE : </td>
                                     <td class="pl-2">BSC. COMPUTER ENGINEERING</td>
                                </tr>
                                <tr>
                                     <td class=" text-right font-weight-bold text-muted">SESSION : </td>
                                     <td class="pl-2">WEEKEND</td>
                                </tr>
                                <tr>
                                     <td class=" text-right font-weight-bold text-muted">NATIONALITY : </td>
                                     <td class="pl-2">GHANAIAN</td>
                                </tr> 
                        </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
