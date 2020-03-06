<?php
/**
 * Created by PhpStorm.
 * User: Smok
 * Date: 29.02.2020
 * Time: 9:49
 */

class MusFundsReference {


    function mus_getReferences($ref_id){
        global $wpdb;

        if($ref_id){
            $sql = $wpdb->prepare("select id, ref_title, ref_name, ref_description from mus_references where id=%d",$ref_id);
        } else {
            $sql = "select id, ref_title, ref_name, ref_description from mus_references";
        }

        try{
            $res = $wpdb->get_results($sql);
        } catch (Exception $e){
            $res = $e->getMessage();
        }


        return  $res;
    }

    function mus_getReferencesValues($ref_id,$ref_value_id){
        global $wpdb;

        if($ref_value_id){
            $sql = $wpdb->prepare("select * from mus_references_value where (ref_id=%d) and (ref_value_id=%d)",$ref_id, $ref_value_id);
        } else {
            $sql = $wpdb->prepare("select * from mus_references_value where (ref_id=%d) ",$ref_id);
        }

        try{
            $res = $wpdb->get_results($sql);
        } catch (Exception $e){
            $res = $e->getMessage();
        }

        return  $res;
    }

    function mus_updateReferences($values){
        global $wpdb;

        if((int) $values['id']){
            $sql = $wpdb->prepare("update mus_references set ref_name = %s, ref_title = %s, ref_description = %s  where id=%d",
                $values['ref_name'],$values['ref_title'], $values['ref_description'], $values['id']);
        } else {
            $sql = $wpdb->prepare("insert into  mus_references (ref_name, ref_title, ref_description)  values (%s ,%s, %s)",
                $values['ref_name'],$values['ref_title'], $values['ref_description']);
        }

        try{
            $res = $wpdb->get_results($sql);
        } catch (Exception $e){
            $res = $e->getMessage();
        }

        return  $res;
    }

    function mus_updateReferencesValues($values){
        global $wpdb;

        if((int) $values['ref_value_id']){
            $sql = $wpdb->prepare("update mus_references_value set ref_value = %s, ref_value_order = %d  where (ref_id =%d) and (ref_value_id = %d)",
                $values['ref_value'],$values['ref_value_order'], $values['ref_id'], $values['ref_value_id']);
        } else {
            $sql = $wpdb->prepare('select max(ref_value_id) as value_id from mus_references_value where ref_id=%d',  $values['ref_id']);
            $res = $wpdb->get_results($sql);
            $sql = $wpdb->prepare("insert into  mus_references_value (ref_value, ref_value_order,ref_id, ref_value_id)  values (%s , %d, %d,%d)",
                $values['ref_value'],$values['ref_value_order'],$values['ref_id'],  ((int) $res[0]->value_id) + 1);
        }

        try{
           $res = $wpdb->get_results($sql);
        } catch (Exception $e){
            $res = $e->getMessage();
        }

        return  $res;
    }


}