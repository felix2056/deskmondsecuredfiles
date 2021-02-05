<template>
    <section class="content">
        <div class="container-fluid">

		<div class="row">
			<section id="feedbackForPupils" class="col-12 col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h6>Teachers feedback</h6> <span id="grade" class="badge grade-level-2" :class="answer.badgeColor">
                            {{ answer.mark }}
                        </span>
					</div>
					<div class="scroll-element">
						<div class="card-body">
							<p v-html="answer.feedback"></p>
						</div>
					</div>
				</div>
			</section>

			<section id="pupilsWork" class="col-12 col-md-6">
				<div class="card h-100">
					<div class="card-header">
						<h6>Your work submitted on {{answer.dateAnswer | formatdate}}</h6>
					</div>
					<div class="scroll-element">
						<div class="card-body">
							<div id="pupilsSubmission">
								<p v-html="answer.answer"></p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/end row-->
		</div>

        </div>
    </section>
</template>

<script>
export default {
    data() {
        return{
            answer: {
                dateAnswer: '',
                answer: '',
                feedback: '',
                dateFeedback: '',
                feedbackByTeacher_id: 0,
                mark: '',
                markValue: 0,
                class_id: 0,
                student_id: 0,
                teacher_id: 0,
                badgeColor: ''
            },
            
            media: [],
            student: {},

        }
    },

    mounted(){
        // check and get the student answer by id
        this.onInit();
    },
    
    filters: {
        'formatdate':function(value){
            if(value){
               // return moment(String(value)).format('LL')
               // rehashed to display today or tomorrow 
               var today = moment(new Date()).format('YYYY-MM-DD');
               var sdate = moment(value).format('YYYY-MM-DD');
               if(sdate == today){
                   return 'Today @';
               }else if(sdate > today){
                   return 'Tomorrow @';
               }else {
                   return moment(String(value)).format('LL');
               }
            }
        },
    },

    methods: {
        onInit() {
            if (this.$route.query.answer_id) {
                let answer_id = this.$route.query.answer_id;
                this.getStudentAnswer(answer_id);
            } else {
               return this.$router.push({name: "dashboard"});
            }

            this.getPupilInfo();
        },

        getStudentAnswer(id){
            //this method extracts the student answer and any attached media
            axios.post('/api/getAnswrByID', {'answer_id': id}).then(res=>{
                console.log('answers=', res);
                this.answer = res.data.answer;

                switch (this.answer.mark) {
                    case 'Excellent':
                        this.answer.badgeColor = 'badge-success';
                        break;

                    case 'Good work':
                        this.answer.badgeColor = 'badge-info';
                        break;

                    case 'Can do better':
                        this.answer.badgeColor = 'badge-warning';
                        break;

                    case 'More effort required':
                        this.answer.badgeColor = 'badge-warning';
                        break;

                    case 'Poor effort':
                        this.answer.badgeColor = 'badge-danger';
                        break;
                }

                this.media = res.data.media;
            }).catch(err=>{
                console.log('get-answ-err', err);
            })
        },

        getPupilInfo(){
            // this method pulls the information about the pupil
            //find the current user - assume its the pupil
            axios.get('/api/getStudentProfile').then(res=>{
                this.pupil = res.data.student;
               console.log('user-data',this.pupil);
               console.log('user-data',res);
               this.student.id = res.data.student.id;
            }).catch(err=>{
                console.log('err-get-pupil', err);
            });
        },
    }
}
</script>