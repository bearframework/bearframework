<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * Base class for lists.
 * @codeCoverageIgnore
 */
class DataList implements \ArrayAccess, \Iterator, \Countable
{

    use \IvoPetkov\DataListTrait;
    use \IvoPetkov\DataListArrayAccessTrait;
    use \IvoPetkov\DataListIteratorTrait;
    use \IvoPetkov\DataListToArrayTrait;
    use \IvoPetkov\DataListToJSONTrait;

    /**
     * Constructs a new data list.
     * 
     * @param array|iterable|callback $dataSource
     * @throws \InvalidArgumentException
     */
    public function __construct($dataSource = null)
    {
        $this->registerDataListClass('IvoPetkov\DataListContext', 'BearFramework\DataList\Context');
        $this->registerDataListClass('IvoPetkov\DataListFilterByAction', 'BearFramework\DataList\FilterByAction');
        $this->registerDataListClass('IvoPetkov\DataListSortByAction', 'BearFramework\DataList\SortByAction');
        $this->registerDataListClass('IvoPetkov\DataListAction', 'BearFramework\DataList\Action');
        $this->registerDataListClass('IvoPetkov\DataListSlicePropertiesAction', 'BearFramework\DataList\SlicePropertiesAction');
        $this->registerDataListClass('IvoPetkov\DataListObject', 'BearFramework\DataObject');
        if ($dataSource !== null) {
            $this->setDataSource($dataSource);
        }
    }

}
