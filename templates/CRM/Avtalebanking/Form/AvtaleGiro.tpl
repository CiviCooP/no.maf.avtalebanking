<div class="crm-block crm-form-block">
  <table class="form-layout">
    <tr>
      <td class="label">{ts}Bank account{/ts}</td>
      <td class="view-value">
      {foreach from=$account.references item=reference name=account_reference}
        <p>
          {if $reference.reference_type eq 'NBAN_DE'}
            {assign var=german value="/"|explode:$reference.reference}
            BLZ:&nbsp;{$german.0}&nbsp;&nbsp;&nbsp;Kto:&nbsp;{$german.1}&nbsp;({ts}German{/ts})
          {elseif $reference.reference_type eq 'ENTITY'}
            {* We hide entity references for the moment *}
          {else}
            <span title="{$reference.reference_type_label}">{$reference.reference}&nbsp;({$reference.reference_type})</span>
          {/if}
        </p>
      {/foreach}
      </td>
    </tr>

    <tr>
      <td class="label">{$form.notification_to_bank.label}</td>
      <td>{$form.notification_to_bank.html}</td>
    </tr>

    <tr>
      <td class="label">{$form.maximum_amount.label}</td>
      <td>{$form.maximum_amount.html}</td>
    </tr>
  </table>

  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
