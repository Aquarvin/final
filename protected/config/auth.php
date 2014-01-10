<?php
return array(
    'newnote'=> array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Доступ к созданию заметки',
        'bizRule' => null,
        'data' => null
    ),
    'delete_and_edit'=> array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Доступ к удалению и редактированию ',
        'bizRule'=>'return Yii::app()->user->getID()==$params["model"]->author_id;',
        'data' => null
    ),

    'role_guest'=>array(
        'type'=> CAuthItem::TYPE_ROLE,
        'description'=>'Guest',
        'bizRule'=>null,
        'data'=>null,
    ),
    'role_author'=>array(
        'type'=> CAuthItem::TYPE_ROLE,
        'description'=>'Author',
        'children'=>array(
            'role_guest',
            'newnote',
            'delete_and_edit',
        ),
        'bizRule' => null,
        'data'=>null,
    ),
    'role_admin'=>array(
        'type'=> CAuthItem::TYPE_ROLE,
        'description'=>'Admin',
        'children'=>array(
            'role_author',
        ),
        'bizRule'=>null,
        'data'=>null,
    ),
);

?>