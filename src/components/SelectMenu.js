import React from "react";
import ButtonGroup from "react-bootstrap/ButtonGroup";
import Dropdown from "react-bootstrap/Dropdown";
import DropdownMenu from "react-bootstrap/DropdownMenu";
import DropdownItem from "react-bootstrap/DropdownItem";
import { Link } from "react-router-dom";
const SelectMenu = (props) => {
  return (
    <ButtonGroup>
      <Dropdown>
        <Dropdown.Toggle>Manage Vendor</Dropdown.Toggle>
        <Dropdown.Menu>
          <Dropdown.Item tag={Link} to="./registerVendor.php">
            Register New
          </Dropdown.Item>
          <Dropdown.Item tag={Link} to="./VendorModify.php">
            Modify Existing
          </Dropdown.Item>
          <Dropdown.Item tag={Link} to="./deleteVendor.php">
            Remove Existing
          </Dropdown.Item>
        </Dropdown.Menu>
      </Dropdown>

      <Dropdown>
        <Dropdown.Toggle>Manage Store</Dropdown.Toggle>
        <DropdownMenu>
          <DropdownItem tag={Link} to="./AddNewStore.php">
            Add New Store
          </DropdownItem>
          <DropdownItem tag={Link} to="./modifyStore.php">
            Modify Existing Store
          </DropdownItem>
          <DropdownItem tag={Link} to="./deletestore.php">
            Remove Store
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>

      <Dropdown>
        <Dropdown.Toggle>Manage Inventory</Dropdown.Toggle>
        <DropdownMenu>
          <DropdownItem tag={Link} to="./InventoryAdd.php">
            Add New Item
          </DropdownItem>
          <DropdownItem tag={Link} to="./InventoryModify.php">
            Modify Existing Item
          </DropdownItem>
          <DropdownItem tag={Link} to="./InventoryDelete.php">
            Remove Existing Item
          </DropdownItem>
          <DropdownItem tag={Link} to="./processDelivery.php">
            Process Delivery
          </DropdownItem>
          <DropdownItem tag={Link} to="./processReturn.php">
            Process Return
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>

      <Dropdown>
        <Dropdown.Toggle>Manage Customer</Dropdown.Toggle>
        <DropdownMenu>
          <DropdownItem tag={Link} to="./CustomerAdd.php">
            Add New Member
          </DropdownItem>
          <DropdownItem tag={Link} to="./CustomerModify.php">
            Modify Member
          </DropdownItem>
          <DropdownItem tag={Link} to="./CustomerDelete.php">
            Remove Member
          </DropdownItem>
          <DropdownItem tag={Link} to="./CustomerNewPurchase.php">
            New Purchase
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>

      <Dropdown>
        <Dropdown.Toggle>Manage Order</Dropdown.Toggle>
        <DropdownMenu>
          <DropdownItem tag={Link} to="./OrderCreate.php">
            New Order
          </DropdownItem>
          <DropdownItem tag={Link} to="./OrderAdd.php">
            Add to Existing
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>

      <Dropdown>
        <Dropdown.Toggle>Look Up</Dropdown.Toggle>
        <DropdownMenu>
          <DropdownItem tag={Link} to="./LookUpAllinv.php">
            All Inventory Items
          </DropdownItem>
          <DropdownItem tag={Link} to="./LookupLowInv.php">
            Add Low Items
          </DropdownItem>
          <DropdownItem tag={Link} to="./LookUpReturns.php">
            Add Returns
          </DropdownItem>
          <DropdownItem tag={Link} to="./LookUpCustPurchase.php">
            Completed Customer Purchases
          </DropdownItem>
          <DropdownItem tag={Link} to="./LookUpOrders.php">
            Placed Orders
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>
    </ButtonGroup>
  );
};
export default SelectMenu;
