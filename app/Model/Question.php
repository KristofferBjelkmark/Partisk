<?php 
/** 
 * Question model
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.Model
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

class Question extends AppModel {
    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange en titel'
            )
        )
    );

    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer'
        )
    );

    public $belongsTo = array(
        'CreatedBy' => array(
            'className' => 'User', 
            'foreignKey' => 'created_by',
            'fields' => array('id', 'username')
        ),
        'UpdatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'updated_by',
            'fields' => array('id', 'username')
        ),
        'ApprovedBy' => array(
            'className' => 'User',
            'foreignKey' => 'approved_by',
            'fields' => array('id', 'username')
        ),
        'QuestionTag'
	);

    public $hasAndBelongsToMany = array(
        'Tag'=> array(
            'joinTable' => "question_tags"
            ),
        'Quiz'=> array(
            'joinTable' => "question_quizzes"
            )
    );

    // TODO: Handle all answer types here (like YESNO)
    public function getChoicesFromQuestion($question) {
        $choices = array();

        if ($question['Question']['type'] == 'CHOICE') {
            foreach ($question['Answer'] as $answer) {
                $choices[$answer['answer']] = $answer['answer'];
            }

            ksort($choices);
            array_unshift($choices, 'ingen åsikt');
        }

        return $choices;
    }

    public function getQuestions($args) {
        $this->recursive = -1; 

        $id = isset($args['id']) ? $args['id'] : null;
        $deleted = isset($args['deleted']) ? $args['deleted'] : null;
        $approved = isset($args['approved']) ? $args['approved'] : null;
        $tagId = isset($args['tagId']) ? $args['tagId'] : null;
        $fields = isset($args['fields']) ? $args['fields'] : array('id', 'title', 'type', 'approved', 'created_by', 'description', 'deleted');
        $conditions = isset($args['conditions']) ? $args['conditions'] : array();

        $joins = array();

        if (isset($id)) { $conditions['id'] = $id; }
        if (isset($approved)) { $conditions['approved'] = $approved; }
        if (isset($deleted)) { $conditions['deleted'] = $deleted; }
        if (isset($partyId)) { $conditions['party_id'] = $partyId; }

        if (isset($tagId)) {
            array_push($joins, array(
                                'table' => 'question_tags as QuestionTag',
                                'conditions' => array('QuestionTag.tag_id' => $tagId,
                                                      'Question.id = QuestionTag.question_id')
                            ));
        }

        $questions = $this->find('all', array(
            'order' => 'Question.title',
            'conditions' => $conditions,
            'joins' => $joins,
            'fields' => $fields
            ));

        return $questions;
    }
    
    public function getQuestion($args) {
        $questions = $this->getQuestions($args);
        return !empty($questions) ? array_pop($questions) : null; 
    }

    public function getLatest() {
        return $this->find('all', array(
                'fields' => 'id, title, approved_date',
                'conditions' => array('deleted' => false, 'approved' => true),
                'limit' => '5',
                'order' => 'approved_date DESC'
            ));
    }

    public function getQuestionById($id) {
        $this->recursive = -1;
        $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy", "Tag.id", "Tag.name"));
        $this->Tag->virtualFields['number_of_questions'] = 0;
        $questions = $this->find('all', array(
                'conditions' => array(
                        'Question.id' => $id
                    ),
                'contain' => 'Tag.deleted = false',
                'fields' => array('Question.id, Question.title, Question.created_date, Question.updated_date, Question.description, 
                                   Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date')
            ));
        return array_pop($questions);
    }

    public function getAllQuestionsList($loggedIn = false) {
        if (!$loggedIn) {
            $conditions = array('Question.deleted' => false, 'Question.approved' => true);
        } else {
            $conditions = array();
        }
        
        return $this->getQuestions(array(
                'conditions' => $conditions,
                'fields' => array('Question.id', 'Question.title', 'Question.approved', 'Question.deleted')
            ));
    }

    public function getQuestionsByQuizId($id) {
        $this->recursive = -1;
        return $this->find('all', array(
                'conditions' => array('deleted' => false, 'approved' => true),
                'joins' => array(array(
                                'table' => 'question_quizzes as QuestionQuiz',
                                'conditions' => array('QuestionQuiz.quiz_id' => $id,
                                                      'Question.id = QuestionQuiz.question_id')
                            )),
                'fields' => array('Question.*, QuestionQuiz.id')
            ));
    }
    
    public function getUserQuestions($userId) {
        $this->recursive = -1;
        return $this->find('all', array(
           'conditions' => array('created_by' => $userId) 
        ));
    }
}

?>