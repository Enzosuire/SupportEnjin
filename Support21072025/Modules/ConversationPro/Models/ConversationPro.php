<?php

namespace Modules\ConversationPro\Models;

use App\Conversation as BaseConversation;
use Modules\Projet\Models\Projet;
use Modules\Jira\Entities\JiraIssue;
use Modules\TimeTracking\Entities\Timelog;

class ConversationPro extends BaseConversation {
   
        //Relation id_projet
       /**
     * Get the projet that owns the conversation.
     */
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }

    //Relation timelogs
    public function timelogs()
    {
        return $this->hasMany(Timelog::class, 'conversation_id');
    }

    //relation numéro de ticket  jira
    public function jiraIssues()
    {
        return $this->belongsToMany(JiraIssue::class, 'jira_issue_conversation', 'conversation_id', 'jira_issue_id');
    }
    
}