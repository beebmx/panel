<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class StructureField extends BaseField{
    public $rule = 'nullable|json';
    public function input(){
        $content = new Brick('div');
        
        $btn = new Brick('a', '<i class="fa fa-plus-circle"></i> Agregar', [
            'href' => '#',
            'data-toggle' => 'modal',
            'data-target' => '#modal-'.$this->id,
            'data-id'     => $this->id
        ]);
        $btn->addClass('modal-add');
        
        $input = new Brick('input');
        $input->attr = [
            'type'           => 'hidden',
            'value'          => $this->value,
            'id'             => $this->id,
            'name'           => $this->name,
            'data-structure' => $this->id,
            'data-fields'    => implode('|', $this->getListFields())
        ];
        if ($this->limit){
            $input->attr['data-limit'] = $this->limit;
        }
        $input->addClass('input');
        $input->addClass('form-control');
        $input->addClass('structure');
        
        $tableContent = new Brick('div');
        $tableContent->addClass('table-responsive-structure');
        $tableContent->addClass('table-responsive');
        
        $table = new Brick('table');
        $table->addClass('table');
        $table = new Brick('table', '<thead></thead><tbody></tbody>', [
            'id'          => 'table-'.$this->id,
            'data-header' => implode('|', $this->getHeaderTable()),
            'data-fields' => implode('|', $this->getShowTableFields())
        ]);
        $table->addClass('table');
        $table->addClass('table-hover');
        $table->addClass('structure');
        
        $tableContent->append($table);
        $content->append($btn);
        $content->append($input);
        $content->append($tableContent);
        
        return $content;
    }
    public function modal(){
        return '
        <div class="modal fade panel-modal" id="modal-'.$this->id.'" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">'.$this->label.'</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-'.$this->id.'" method="post" action="#">
                            <div class="container-fluid">
                            '.$this->getFields().'
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save-structure">Save changes</button>
                    </div>
                </div>
            </div>
        </div>';
    }
    
    public function getFields(){
        $fields = '';
        foreach($this->fields as $id => $field){
            $classField = $this->getClassField($this->fields[$id]['type']);
            if ($classField::$stored){
                $current = new $classField($id, $this->fields[$id], false, 'modal');
                if ($current->template()) {
                    $fields .= $current->template();
                }
            }
        }
        return $fields;
    }
    public function getHeaderTable(){
        $fields = [];
        foreach($this->fields as $field => $data){
            if (isset($data['list']) ? $data['list'] : true){
                $fields[] = $data['name'];
            }
        }
        return $fields;
    }
    public function getShowTableFields(){
        $fields = [];
        foreach($this->fields as $field => $data){
            if (isset($data['list']) ? $data['list'] : true){
                $fields[] = $field;
            }
        }
        return $fields;
    }
    public function getListFields(){
        $fields = [];
        foreach($this->fields as $field => $data){
            $fields[] = $field;
        }
        return $fields;
    }
    private function getClassField($type){
        $type = ucwords($type);
        if (class_exists('Beebmx\\Panel\\Fields\\' . $type . 'Field')){
            return 'Beebmx\\Panel\\Fields\\' . $type . 'Field';
        }else{
            $filename = app_path('Panel/Fields/'.$type.'/'.$type.'.php');
            return $this->getFullNamespace($filename).'\\' . $type . 'Field';
        }
    }
    public function inputShow() {
        $content = new Brick('div');
        
        $input = new Brick('input');
        $input->attr = [
            'type'           => 'hidden',
            'value'          => $this->value,
            'id'             => $this->id,
            'name'           => $this->name,
            'data-structure' => $this->id,
            'data-fields'    => implode('|', $this->getListFields())
        ];
        if ($this->limit){
            $input->attr['data-limit'] = $this->limit;
        }
        $input->addClass('input');
        $input->addClass('form-control');
        $input->addClass('structure');
        
        $tableContent = new Brick('div');
        $tableContent->addClass('table-responsive-structure');
        $tableContent->addClass('table-responsive');
        
        $table = new Brick('table');
        $table->addClass('table');
        $table = new Brick('table', '<thead></thead><tbody></tbody>', [
            'id'          => 'table-'.$this->id,
            'data-header' => implode('|', $this->getHeaderTable()),
            'data-fields' => implode('|', $this->getShowTableFields())
        ]);
        $table->addClass('table');
        $table->addClass('table-hover');
        $table->addClass('structure');
        
        $tableContent->append($table);
        $content->append($input);
        $content->append($tableContent);
        
        return $content;

    }
}
