{if $bank_accounts}
    <div>
        <table id="contact-activity-selector-dashlet">
            <thead>
            <tr>
                <th>
                    <div>{ts}Bank Account{/ts}</div>
                </th>
                <th>
                    <div>{ts}Notification to bank{/ts}</div>
                </th>
                <th>
                    <div>{ts}Maximum amount{/ts}</div>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$bank_accounts item=account}
                <tr class="{cycle values="odd,even"}">
                    <td>
                        <table style="border: 0;">
                            {foreach from=$account.references item=reference name=account_reference}
                                <tr>
                                    <td>
                                        {if $reference.reference_type eq 'NBAN_DE'}
                                            {assign var=german value="/"|explode:$reference.reference}
                                            BLZ:&nbsp;{$german.0}&nbsp;&nbsp;&nbsp;Kto:&nbsp;{$german.1}&nbsp;({ts}German{/ts})
                                        {elseif $reference.reference_type eq 'ENTITY'}
                                            {* We hide entity references for the moment *}
                                        {else}
                                            <span title="{$reference.reference_type_label}">{$reference.reference}&nbsp;({$reference.reference_type})</span>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                    <td>
                        {if ($account.notification_to_bank)}
                            {ts}Send notification to bank{/ts}
                        {else}
                            {ts}Do not send notification to bank{/ts}
                        {/if}
                    </td>
                    <td>
                        {$account.maximum_amount}
                    </td>
                    <td style="vertical-align: middle;">
                        <a title="{ts}Edit{/ts}" class="edit button" href="{$account.edit_link}">
                            <span><div class="icon edit-icon ui-icon-pencil"></div>{ts}Edit{/ts}</span>
                        </a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
{else}
    <h3>{ts}This contact has no known accounts associated with him/her.{/ts}</h3>
{/if}
