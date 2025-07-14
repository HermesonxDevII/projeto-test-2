<?php

namespace App\Services;

use App\Enums\ConversationType;
use App\Enums\ParticipantRole;
use Illuminate\Http\Request;
use App\Models\{Classroom, Conversation, Schedule, Course, Group, Student, User};
use Doctrine\DBAL\Portability\Converter;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Auth, DB, Log, Storage};

class ChatService
{
    static public function createGroup (Classroom $classroom, array $courses): void
    {
        try { 
            // Cria a conversa em grupo
            $adms = User::whereHas('roles', function($query) {$query->where('roles.id', 1);})->get();
            $userAdm = User::where('email','contato@smartlead.com.br')->first();

            $conversation = new Conversation();
            $conversation->type = ConversationType::GROUP;
            $conversation->save();

            $conversation->group()->create([
                'name' => $classroom->name,
                'description' => $classroom->description,
                'allow_members_to_send_messages' => 0,
                'classroom_id' => $classroom->id,
            ]);

            // Adicionar adm smartlead como owner dos grupos
            $conversation->addParticipant($userAdm, ParticipantRole::OWNER);

            // Adiciona os professores como participantes
            foreach ($courses as $course) {
                $course->load('teacher'); // garante que o teacher está carregado

                if ($course->teacher) {
                    $alreadyExists = $conversation->participants()
                        ->where('participantable_id', $course->teacher->id)
                        ->where('participantable_type', $course->teacher->getMorphClass())
                        ->exists();

                    if (! $alreadyExists) {
                        $conversation->addParticipant($course->teacher, ParticipantRole::ADMIN);
                    }
                }
            }

            // Adiciona os administradores como participantes
            foreach($adms as $adm) {
                $alreadyExists = $conversation->participants()
                    ->where('participantable_id', $adm->id)
                    ->where('participantable_type', $adm->getMorphClass())
                    ->exists();

                if (! $alreadyExists) {
                    $conversation->addParticipant($adm, ParticipantRole::ADMIN);
                }
            }

        } catch (Exception $e) {
            Log::error('Erro ChatService::createGroup',['message' => $e->getMessage()]);
        }
        

    }

    static public function addStudent (Classroom $classroom, int $student_id): void
    {
        $groupChat = Group::where('classroom_id', $classroom->id)->first();
        
        if( $groupChat ){
            $conversation = Conversation::find($groupChat->conversation_id);

            $student = Student::find($student_id);

                if( $student ){
                    $alreadyExists = $conversation->participants()->where('participantable_id', $student->id)->where('participantable_type', $student->getMorphClass())->first();

                    if($alreadyExists) {

                        if($alreadyExists->hasExited()) {
                            $alreadyExists->exited_at = null;

                            $alreadyExists->save();
                        }


                    } else {
                        $conversation->addParticipant($student);
                    }

                }
        }
        
    }

    static public function addTeacher (Classroom $classroom, int $teacher_id): void
    {
        $groupChat = Group::where('classroom_id', $classroom->id)->first();
        
        if( $groupChat ){
            $conversation = Conversation::find($groupChat->conversation_id);

            $teacher = User::find($teacher_id);

                if( $teacher ){
                    $alreadyExists = $conversation->participants()->where('participantable_id', $teacher->id)->where('participantable_type', $teacher->getMorphClass())->first();

                    if($alreadyExists) {

                        if($alreadyExists->hasExited()) {
                            $alreadyExists->exited_at = null;

                            $alreadyExists->save();
                        }


                    } else {
                        $conversation->addParticipant($teacher);
                    }

                }
        }
        
    }

    static public function removeParticipant (Classroom $classroom, int $participant_id, $participant_type = "student"): void
    {
        $groupChat = Group::where('classroom_id', $classroom->id)->first();
        
        if( $groupChat ){
            $conversation = Conversation::find($groupChat->conversation_id);

            $participant = $participant_type === "student" ? Student::find($participant_id) : User::find($participant_id);

                if( $participant ){
                    $existingParticipant = $conversation->participants()->where('participantable_id', $participant->id)->where('participantable_type', $participant->getMorphClass())->first();

                    if ($existingParticipant) {
                        
                        $existingParticipant->exitConversation();
                    }
                }

            
        }
        
    }
}