<?php 
namespace ZfcDB\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Form\Annotation\Object;

interface MapperInterface{
	/**
	 * @return Select
	 */
	public function getSelect();
	
	/**
	 * @return array
	 */
	public function getColumns();
	
	/**
	 * @return dbAdapter
	 */
	public function getDbAdapter();
	
	/**
	 * @return string
	 */
	public function getTableName();
	
	/**
	 * @return HydratorInterface
	 */
	public function getHydrator();
	
	/**
	 * @return object
	 */
	public function getEntityPrototype();
	
	/**
	 * @param mixed $data
	 * @return MapperInterface
	 */
	public function save($data);
	
	/**
	 * @param array $dataList
	 * @return MapperInterface
	 */
	public function saveList(array $dataList);
	
	/**
	 * @param mixed $data
	 * @return MapperInterface
	 */
	public function delete($data);
	
	/**
	 * @param array $dataList
	 * @return MapperInterface
	*/
	public function deleteList(array $dataList);
	
	/**
	 * 
	 * @param array $criteria
	 */
	public function fetch( array $criteria = null );
	
	/**
	 * 
	 * @param array $id
	 */
	public function fetchById( $id );
	
	/**
	 * 
	 * @param array $criteria
	 * @param array $orderBy
	 * @param string $limit
	 * @param string $offset
	 */
	public function fetchBy( array $criteria, array $orderBy = null, $limit = null, $offset = null );
	
	/**
	 * 
	 * @param array $criteria
	 * @param array $orderBy
	 */
	public function fetchOneBy( array $criteria, array $orderBy = null );

}