<script>

	import { slide } from 'svelte/transition';
	import ClosedIcon from './ClosedIcon.svelte';
	import OpenedIcon from './OpenIcon.svelte';
	import DotIcon from './DotIcon.svelte';

    export let treeprops
	export let node
	export let level = 0
    export let nodeClick
	
	function toggle() {
		node.expanded = !node.expanded;
	}


</script>


<style>
    .tiklanabilir {cursor:pointer;}
    .expand {cursor:no-drop;}
</style>

<li style="padding-left:{level*1}rem" transition:slide id="libranch{node.id}">

	{#if node.children.length > 0}

		{#if !node.expanded}
            <span class="icon-text">
                <span class="icon expand" on:click={toggle}><ClosedIcon/></span>
                <span class="tiklanabilir" on:click={nodeClick} data-id={node.id}>{node[treeprops.titleColumn]}</span>
            </span>
		{:else}
            <span class="icon-text">
                <span class="icon expand" on:click={toggle}><OpenedIcon/></span>
                <span class="tiklanabilir has-text-weight-bold" on:click={nodeClick} data-id={node.id}>{node[treeprops.titleColumn]}</span>
            </span>
		{/if}
		
	{:else}
        <span class="icon-text">
            <span class="icon"><DotIcon/></span>
            <span class="tiklanabilir" on:click={nodeClick} data-id={node.id}>{node[treeprops.titleColumn]}</span>
        </span>
	{/if}

</li>

{#if node.expanded && node.children}
    {#each node.children as child}
        <svelte:self node={child} level={level+1} {treeprops} {nodeClick} />
    {/each}
{/if}