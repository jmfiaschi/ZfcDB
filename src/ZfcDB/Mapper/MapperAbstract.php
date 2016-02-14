<?php 
namespace ZfcDB\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use ZfcDB\Mapper\MapperInterface;
use Zend\Db\Metadata\Metadata;

class MapperAbstract extends AbstractDbMapper implements MapperInterface
{
	/**
	 * @var array
	 */
	protected $columns = null;
	
	/**
	 * (non-PHPdoc)
	 * @see \ZfcDB\Mapper\MapperInterface::getColumns()
	 */
	public function getColumns() {
		if(!$this->columns){
			$columns = $this->getHydrator()->extract($this->getEntityPrototype());
				
			$this->columns = array_keys($columns);
		}
		return $this->columns;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \ZfcBase\Mapper\AbstractDbMapper::getSelect()
	 */
	public function getSelect($table = null){
		return parent::getSelect($table);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \ZfcBase\Mapper\AbstractDbMapper::getTableName()
	 */
	public function getTableName(){
		return $this->tableName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \ZfcDB\Mapper\MapperInterface::save()
	 */
	public function save($object){
		$metadata = new Metadata($this->getDbAdapter());
		$constraints = $metadata->getConstraints($this->tableName);
		$datas = $object;
		if(!is_array($datas)){
			$datas = $this->getHydrator()->extract($object);
		}
		
		$primaries = array();
		if(count($constraints)){
			foreach($constraints as $constraint){
				if($constraint->getType() == "PRIMARY KEY"){
					$primaries = $constraint->getColumns();
				}
			}
		}
		
		$edit = true;
		if(count($primaries)){
			foreach($primaries as $primarie){
				if(empty($datas[$primarie])){
					$edit = false;
					break;
				}
			}
		}
		
		$this->getEventManager()->trigger(__FUNCTION__, $this, array('entity' => $object));
		
		if($edit){
			$this->update($datas,array_intersect_key($datas,array_flip($primaries)));
		}else{
			$this->insert($datas);
		}
		
		$this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('entity' => $object));
		
		return $this;
	}
}